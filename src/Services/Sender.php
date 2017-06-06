<?php

namespace Librinfo\EmailCRMBundle\Services;

use Librinfo\EmailBundle\Services\Sender as BaseSender;
use Librinfo\EmailCRMBundle\Services\SwiftMailer\DecoratorPlugin\Replacements;

class Sender extends BaseSender
{

    /**
     * Sends an email
     * 
     * @param Email $email the email to send
     * @return int number of successfully sent emails
     */
    public function send($email)
    {
        $this->email = $email;
        $this->attachments = $email->getAttachments();
        $addresses = explode(';', $this->email->getFieldTo());

        if ($email->getPositions() === null) {
            $email->initPositions();
        }

        foreach ($email->getPositions() as $position) {
            $name = sprintf(
                '%s %s', $position->getIndividual()->getFirstName(), $position->getIndividual()->getName()
            );

            if ($position->getEmail())
                $addresses[$name] = $position->getEmail();
            else if ($position->getIndividual()->getEmail())
                $addresses[$name] = $position->getIndividual->getEmail();
            else
                continue;
        }
        
        if ($email->getOrganisms() === null) {
            $email->initOrganisms();
        }

        foreach ($email->getOrganisms() as $organism) {
            if ($organism->getEmail()) {
                if ($organism->isIndividual()) {
                    $name = sprintf(
                        '%s %s', $organism->getFirstName(), $organism->getName()
                    );

                    $addresses[$name] = $organism->getEmail();
                } else {
                    $addresses[$organism->getName()] = $organism->getEmail();
                }
            }
        }

        $this->needsSpool = count($addresses) > 1;

        if ($this->email->getIsTest())
            return $this->directSend($this->email->getTestAddress());

        if ($this->needsSpool)
            return $this->spoolSend($addresses);

        return $this->directSend($addresses);
    }

    protected function directSend($to, &$failedRecipients = null, $message = null)
    {
        $message = $this->setupSwiftMessage($to, $message);
        $replacements = new Replacements($this->manager);
        $decorator = new \Swift_Plugins_DecoratorPlugin($replacements);

        $this->directMailer->registerPlugin($decorator);
        $sent = $this->directMailer->send($message, $failedRecipients);
        $this->updateEmailEntity($message);

        return $sent;
    }

}
