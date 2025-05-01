<?php

namespace App\User\Entity;

use App\User\Enum\UserRole;
use App\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Ignore;
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

    #[Ignore]
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

    #[ORM\Column(
        type: 'json',
        options: ['comment' => 'Роли пользователя']
    )]
    private array $roles = [];

    private function __construct(
        string $email,
        ?string $phone = null,
        array $roles = []
    )
    {
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setRoles($roles);
    }

    public static function create(
        string $email,
        ?string $phone = null,
        array $roles = []
    ): User
    {
        return new self($email, $phone, $roles);
    }

    public function update(
        string $email,
        string $phone,
        array $roles = []
    ): User
    {
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setRoles($roles);

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

    public function setPassword(string $password, UserPasswordHasherInterface $hasher): void
    {
        $this->password = $hasher->hashPassword($this, $password);
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

    private function setRoles(array $roles): void
    {
        foreach ($roles as $role) {
            Assert::notNull(
                UserRole::tryFrom($role),
                "Роли $role не существует"
            );
        }

        $this->roles = $roles;

        if (!in_array(UserRole::USER->value, $this->roles)) {
            $this->roles[] = UserRole::USER->value;
        }
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    #[Ignore]
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }
}
