<?php

namespace App\User\Service;

use App\User\Cache\ConfirmationCodeCache;
use App\User\Entity\User;
use App\User\Producer\MailProducer;
use App\User\Repository\UserRepository;
use App\User\ValueObject\ConfirmationCode;
use App\User\ValueObject\RegistrationMail;
use Symfony\Component\Mime\Address;

class RegistrationService
{
    public function __construct(
        private MailProducer $mailProducer,
        private ConfirmationCodeCache $cache,
        private UserRepository $userRepository
    ) {}

    public function sendConfirmationCode(User $user): ConfirmationCode
    {
        $confirmationCode = new ConfirmationCode();

        $this->mailProducer->produce(
            new RegistrationMail(
                to: new Address($user->getEmail()),
                confirmationCode: $confirmationCode
            )
        );

        $this->cache->delete($user->getId());

        $this->cache->save($user->getId(), $confirmationCode->getCode());

        return $confirmationCode;
    }

    public function checkConfirmationCode(User $user, ConfirmationCode $confirmationCode): void
    {
        $code = $this->cache->get($user->getId());

        if (is_null($code)) {
            throw new \RuntimeException('Ваш код подтверждения не найден. Получите новый!', 400);
        }

        if ($code === $confirmationCode->getCode()) {
            $user->confirm();
            $this->cache->delete($user->getId());
            $this->userRepository->add($user);
        } else {
            throw new \RuntimeException('Неверный код подтверждения', 400);
        }
    }
}