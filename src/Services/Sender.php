<?php

/*
 * This file is part of the Lisem Project.
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU GPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Librinfo\EmailCRMBundle\Services;

use Librinfo\EmailBundle\Services\Sender as BaseSender;
use Librinfo\EmailCRMBundle\Services\SwiftMailer\DecoratorPlugin\Replacements;

class Sender extends BaseSender
{
    /**
     * Sends an email.
     *
     * @param Email $email the email to send
     *
     * @return int number of successfully sent emails
     */
    public function send($email)
    {
        $this->email = $email;
        $this->attachments = $email->getAttachments();
        $addresses = $this->email->getFieldToAsArray();

        if ($email->getPositions() === null) {
            $email->initPositions();
        }

        foreach ($email->getPositions() as $position) {
            $name = sprintf(
                '%s %s', $position->getIndividual()->getFirstName(), $position->getIndividual()->getName()
            );

            if ($position->getEmail()) {
                $addresses[$name] = $position->getEmail();
            } elseif ($position->getIndividual()->getEmail()) {
                $addresses[$name] = $position->getIndividual->getEmail();
            } else {
                continue;
            }
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

        if ($email->getCircles() === null) {
            $email->initCircles();
        }

        foreach ($email->getCircles() as $circle) {
            foreach ($circle->getOrganisms() as $organism) {
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

        $this->needsSpool = (count($addresses) > 1);
        // dump($addresses,$this->email);die;

        if ($this->email->getIsTest()) {
            return $this->directSend($this->email->getTestAddressAsArray());
        }

        if ($this->needsSpool) {
            return $this->spoolSend($addresses);
        }

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
