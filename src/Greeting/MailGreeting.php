<?php

namespace App\Greeting;

class MailGreeting implements GreetingInterface
{
    public function hello(): string
    {
        return "hello from mail greeting!";
    }
}