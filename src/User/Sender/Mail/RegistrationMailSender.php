<?php

namespace App\User\Sender\Mail;

use App\User\ValueObject\RegistrationMail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class RegistrationMailSender
{
    public function __construct(private MailerInterface $mailer)
    {}

    public function send(RegistrationMail $mail)
    {
        try {
            $this->mailer->send($mail);
        } catch (TransportExceptionInterface) {
            throw new TransportException(
                'Не удалось отправить сообщение', Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}