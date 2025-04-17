<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(
        length: 255,
        options: ['comment' => 'Название товара']
    )]
    private string $name;

    #[ORM\Column(
        length: 255,
        unique: true,
        options: ['comment' => 'Человеко-понятный URL-идентификатор товара']
    )]
    private string $slug;

    #[ORM\Column(
        type: Types::TEXT,
        nullable: true,
        options: ['comment' => 'Полное описание товара']
    )]
    private ?string $description;

    #[ORM\Column(
        type: Types::DECIMAL,
        precision: 10,
        scale: 2,
        options: ['comment' => 'Текущая цена товара']
    )]
    private string $price;

    #[ORM\Column(
        type: Types::DECIMAL,
        precision: 10,
        scale: 2,
        nullable: true,
        options: ['comment' => 'Старая цена (для отображения скидки)']
    )]
    private ?string $oldPrice = null;

    #[ORM\Column(
        length: 100,
        unique: true,
        options: ['comment' => 'Артикул/уникальный код товара (Stock Keeping Unit)']
    )]
    private int $sku;

    #[ORM\Column(
        options: [
            'comment' => 'Количество товара на складе',
            'default' => 0
        ]
    )]
    private int $quantity;

    #[ORM\Column(
        options: [
            'comment' => 'Флаг активности товара (отображается ли на сайте)',
            'default' => false
        ]
    )]
    private bool $isActive;

    #[ORM\Column(
        options: ['comment' => 'Дата и время создания записи']
    )]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(
        options: ['comment' => 'Дата и время последнего обновления']
    )]
    private DateTimeImmutable $updatedAt;

    private function __construct(
        string $name,
        ?string $description,
        string $price,
        int $quantity,
        bool $isActive,
    )
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->isActive = $isActive;

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public static function create(
        string $name,
        ?string $description,
        string $price,
        int $quantity,
        bool $isActive,
    ): self
    {
        return new self(
            $name,
            $description,
            $price,
            $quantity,
            $isActive
        );
    }

    public static function update(
        Product $product,
        string $name,
        ?string $description,
        string $price,
        int $quantity,
        bool $isActive)
    {
        $product->setName($name);
        $product->setDescription($description);
        $product->updatePrice($price);
        $product->setQuantity($quantity);
        $product->isActive = $isActive;

        return $product;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function setName(string $name): void
    {
        Assert::stringNotEmpty($name, 'Имя продукта не может быть пустым. Получено: %s');
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    private function setDescription(?string $description): void
    {
        Assert::stringNotEmpty($description, 'Описание продукта не может быть пустым. Получено: %s');
        $this->description = $description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    private function setPrice(string $price): void
    {
        Assert::stringNotEmpty($price, 'Цена продукта не может быть пустой. Получено: %s');
        Assert::greaterThan($price, 0, 'Цена продукта не может быть < 0. Получено: %s');

        $this->price = $price;
    }

    private function updatePrice(string $price): void
    {
        Assert::stringNotEmpty($price, 'Цена продукта не может быть пустой. Получено: %s');
        Assert::greaterThan($price, 0, 'Цена продукта не может быть < 0. Получено: %s');

        if ($this->price != $price) {
            $this->oldPrice = $this->price;
        }

        $this->price = $price;
    }

    public function getOldPrice(): ?string
    {
        return $this->oldPrice;
    }

    public function getSku(): int
    {
        return $this->sku;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    private function setQuantity(int $quantity): void
    {
        Assert::greaterThanEq($quantity, 0, 'Количество продукта не может быть < 0. Получено: %s');
        $this->quantity = $quantity;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function updateUpdatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function computeSlug(SluggerInterface $slugger): string
    {
        $slug = (string) $slugger->slug($this->name)->lower();
        $this->slug = $slug;

        return $slug;
    }

    public function computeSku()
    {
        $sku = random_int(1000, 9999);
        $this->sku = $sku;

        return $sku;
    }
}
