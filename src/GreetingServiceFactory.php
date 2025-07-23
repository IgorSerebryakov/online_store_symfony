<?php

namespace App;

use App\Greeting\GreetingInterface;
use App\Greeting\MailGreeting;
use App\Greeting\SmsGreeting;

class GreetingServiceFactory
{
    public function create(string $type): GreetingInterface
    {
        return match ($type) {
            'mail' => new MailGreeting(),
            'sms' => new SmsGreeting()
        };
    }
}