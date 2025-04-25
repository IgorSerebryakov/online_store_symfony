<?php

namespace App\User\Entity;

use App\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'UUID')]
    #[ORM\Column]
    private int $id;

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

    public function create(
        string $email,
        string $password,
        ?string $phone = null
    ): User
    {
        return new self($email, $password, $phone);
    }

    public function getId(): int
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    private function setPhone(?string $phone): static
    {
        if (!is_null($phone)) {
            Assert::numeric($phone, 'Телефон должен быть числом. Получено: %s');
            Assert::maxLength($phone, 11, 'Телефон должен содержать 11 цифр. Получено: %s');
            Assert::startsWith($phone, '7', 'Телефон должен начинаться с цифры "7", получено: %s');
        }

        $this->phone = $phone;

        return $this;
    }
}
