<?php

namespace Librinfo\EmailCRMBundle\Services\SwiftMailer\Spool;

use Librinfo\EmailBundle\Services\SwiftMailer\Spool\DbSpool as BaseDbSpool;
use Librinfo\EmailCRMBundle\Services\SwiftMailer\DecoratorPlugin\Replacements;

/**
 * Class DbSpool
 */
class DbSpool extends BaseDbSpool
{
    public function flushQueue(\Swift_Transport $transport, &$failedRecipients = null)
    {
        $replacements = new Replacements($this->manager);
        $decorator = new \Swift_Plugins_DecoratorPlugin($replacements);
        $transport->registerPlugin($decorator);
        
        return parent::flushQueue($transport, $failedRecipients);
    }
}
