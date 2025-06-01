<?php

namespace App\User\Producer;

use App\User\ValueObject\RegistrationMail;
use Symfony\Component\Messenger\MessageBusInterface;

class MailProducer
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function produce(RegistrationMail $mail): void
    {
        $this->messageBus->dispatch($mail);
    }
}