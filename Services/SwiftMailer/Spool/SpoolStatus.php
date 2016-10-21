<?php

namespace Librinfo\EmailBundle\Services\SwiftMailer\Spool;

interface SpoolStatus
{
    const STATUS_FAILED = -1;
    const STATUS_READY = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_COMPLETE = 3;
}
