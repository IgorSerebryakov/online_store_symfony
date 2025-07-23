<?php

namespace App\User\Entity;

use App\User\Repository\UserRegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRegistrationRepository::class)]
class UserRegistration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $emailConfirmToken = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $tokenExpiresAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailConfirmToken(): ?string
    {
        return $this->emailConfirmToken;
    }

    public function setEmailConfirmToken(string $emailConfirmToken): static
    {
        $this->emailConfirmToken = $emailConfirmToken;

        return $this;
    }

    public function getTokenExpiresAt(): ?\DateTimeImmutable
    {
        return $this->tokenExpiresAt;
    }

    public function setTokenExpiresAt(\DateTimeImmutable $tokenExpiresAt): static
    {
        $this->tokenExpiresAt = $tokenExpiresAt;

        return $this;
    }
}
