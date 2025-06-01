<?php

namespace App\User\ValueObject;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Messenger\Attribute\AsMessage;
use Symfony\Component\Mime\Address;

#[AsMessage('async_registration_mail')]
final class RegistrationMail extends TemplatedEmail
{
    const FROM = 'online_store_registration@mail.ru';

    public function __construct(
        Address $to,
        ConfirmationCode $confirmationCode,
    )
    {
        parent::__construct();

        $this
            ->from(new Address(self::FROM, self::FROM))
            ->to($to)
            ->subject('Подтверждение регистрации online_store_symfony')
            ->htmlTemplate('registration/email/registration.html.twig')
            ->context([
                'confirmation_code' => $confirmationCode->getCode()
            ]);
    }
}