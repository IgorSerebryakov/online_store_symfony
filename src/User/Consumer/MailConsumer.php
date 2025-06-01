<?php

namespace App\User\Consumer;

use App\User\Sender\Mail\RegistrationMailSender;
use App\User\ValueObject\RegistrationMail;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'async_registration_mail')]
class MailConsumer
{
    public function __construct(private RegistrationMailSender $sender)
    {}

    public function __invoke(RegistrationMail $mail): void
    {
        $this->sender->send($mail);
    }
}