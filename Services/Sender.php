<?php

namespace Librinfo\EmailCRMBundle\Services;

use Librinfo\EmailBundle\Services\Sender as BaseSender;
use Librinfo\EmailCRMBundle\Services\SwiftMailer\DecoratorPlugin\Replacements;

class Sender extends BaseSender
{
    protected function directSend($to, &$failedRecipients = null)
    {
        $message = $this->setupSwiftMessage($to, $this->email->getFieldCc(), $this->email->getFieldBcc());

        $replacements = new Replacements($this->manager);
        $decorator = new \Swift_Plugins_DecoratorPlugin($replacements);
        $this->directMailer->registerPlugin($decorator);

        $sent = $this->directMailer->send($message, $failedRecipients);
        $this->updateEmailEntity($message);

        return $sent;
    }
    
}
