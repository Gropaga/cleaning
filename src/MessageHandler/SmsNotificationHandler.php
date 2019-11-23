<?php

namespace CleaningCRM\MessageHandler;

use CleaningCRM\Message\SmsNotification;

class SmsNotificationHandler
{
    public function __invoke(SmsNotification $message)
    {
        dump($message);
    }
}
