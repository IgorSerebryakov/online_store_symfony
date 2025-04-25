<?php

namespace App\User\EventListener;

use App\Product\Entity\Product;
use App\Product\Service\SkuGenerator;
use App\Product\Validator\UniqueProductSkuValidator;
use App\Product\Validator\UniqueProductSlugValidator;
use App\User\Entity\User;
use App\User\Validator\UniqueUserEmailValidator;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsEntityListener(event: Events::prePersist, entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, entity: User::class)]
readonly class UserEntityListener
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private UniqueUserEmailValidator    $uniqueUserEmailValidator,
    )
    {}

    public function __invoke(User $user, LifecycleEventArgs $args): void
    {
        $user->update(
            $user->getEmail(),
            $this->hasher->hashPassword($user, $user->getPassword()),
            $user->getPhone()
        );

        $this->uniqueUserEmailValidator->validate($user->getEmail(), $user);
    }
}