<?php

namespace App\User\Entity;

use App\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private string $id;

    #[ORM\Column(
        length: 255,
        unique: true,
        options: ['comment' => 'Email пользователя']
    )]
    private string $email;

    #[ORM\Column(
        length: 255,
        options: ['comment' => 'Захэшированный пароль пользователя']
    )]
    private ?string $password;

    #[ORM\Column(
        length: 255,
        nullable: true,
        options: ['comment' => 'Телефон пользователя']
    )]
    private ?string $phone = null;

    private function __construct(
        string $email,
        string $password,
        ?string $phone = null
    )
    {
        $this->setEmail($email);
        $this->setPhone($phone);

        $this->password = $password;
    }

    public static function create(
        string $email,
        string $password,
        ?string $phone = null
    ): User
    {
        return new self($email, $password, $phone);
    }

    public function update(
        string $email,
        string $password,
        string $phone
    )
    {
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setPhone($phone);

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    private function setEmail(string $email): static
    {
        Assert::email($email, 'Значение не соответствует электронному почтовому адресу. Получено: %s');
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    private function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    private function setPhone(?string $phone): static
    {
        if (!is_null($phone)) {
            Assert::regex(
                $phone,
                '/^7\d{10}$/',
                'Телефон должен начинаться с "7" и содержать 11 цифр. Получено: %s');
        }

        $this->phone = $phone;

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }
}
