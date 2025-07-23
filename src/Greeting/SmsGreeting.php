<?php

namespace App\Greeting;

class SmsGreeting implements GreetingInterface
{
    public function hello(): string
    {
        return "hello from sms greeting!";
    }
}