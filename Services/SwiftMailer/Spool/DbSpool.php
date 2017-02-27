<?php

namespace Librinfo\EmailCRMBundle\Services\SwiftMailer\Spool;

use Librinfo\EmailBundle\Services\SwiftMailer\Spool\DbSpool as BaseDbSpool;
use Librinfo\EmailBundle\Services\SwiftMailer\Spool\SpoolStatus;
use Librinfo\EmailBundle\Services\InlineAttachments;
use Librinfo\EmailCRMBundle\Services\SwiftMailer\DecoratorPlugin\Replacements;

/**
 * Class DbSpool
 */
class DbSpool extends BaseDbSpool
{   
    /**
     * Sends messages using the given transport instance.
     *
     * @param \Swift_Transport $transport         A transport instance
     * @param string[]        &$failedRecipients An array of failures by-reference
     *
     * @return int The number of sent emails
     */
    public function flushQueue(\Swift_Transport $transport, &$failedRecipients = null)
    {
        $replacements = new Replacements($this->manager);
        $decorator = new \Swift_Plugins_DecoratorPlugin($replacements);
        
        $transport->registerPlugin($decorator);
        
        if (!$transport->isStarted())
        {
            $transport->start();
        }

        $emails = $this->repository->findBy(
                array("status" => SpoolStatus::STATUS_READY, "environment" => $this->environment), null
        );

        if (!count($emails))
        {
            return 0;
        }

        $failedRecipients = (array) $failedRecipients;
        $count = 0;
        $time = time();

        foreach ($emails as $email)
        {
            $email->setStatus(SpoolStatus::STATUS_PROCESSING);

            $this->updateEmail($email);

            $message = unserialize(base64_decode($email->getMessage()));

            $addresses = explode(';', $email->getFieldTo());
            
            foreach ( $email->getPositions() as $position )
            {
                $name = sprintf(
                        '%s %s', $position->getContact()->getFirstName(), $position->getContact()->getName()
                );

                if ( $position->getEmail() )
                    $addresses[$name] = $position->getEmail();
                else if ( $position->getContact()->getEmail() )
                    $addresses[$name] = $position->getContact->getEmail();
                else
                    continue;
            }

            foreach ( $email->getContacts() as $contact )
                if ( $contact->getEmail() )
                {
                    $name = sprintf(
                            '%s %s', $contact->getFirstName(), $contact->getName()
                    );
                
                    $addresses[$name] = $contact->getEmail();
                }
                
            foreach ( $email->getOrganisms() as $organism )
                if ( $organism->getEmail() )
                    $addresses[$organism->getName()] = $organism->getEmail();

            foreach ($addresses as $address)
            {               
                $message->setTo(trim($address));
                $content = $email->getContent();
                
                if ($email->getTracking())
                {
                    $tracker = new Tracking($this->router);
                    $content = $tracker->addTracking($content, $address, $email->getId());
                }
                
                $attachmentsHandler = new InlineAttachments();
                $content = $attachmentsHandler->handle($content, $message);

                $message->setBody($content);
                
                try {
                    $count += $transport->send($message, $failedRecipients);
                    sleep($this->pauseTime);
                } catch (\Swift_TransportException $e) {
                    $email->setStatus(SpoolStatus::STATUS_READY);
                    $this->updateEmail($email);
                    dump($e->getMessage());
                }
            }
            $email->setStatus(SpoolStatus::STATUS_COMPLETE);

            $this->updateEmail($email);

            if ($this->getTimeLimit() && (time() - $time) >= $this->getTimeLimit())
            {
                break;
            }
        }
        return $count;
    }
}
