<?php

namespace App\Category\Entity;

use App\Category\Repository\CategoryRepository;
use App\Product\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[Groups('product_show')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private int $id;

    #[Groups('product_show')]
    #[ORM\Column(
        length: 255,
        options: ['comment' => 'Наименование категории']
    )]
    private string $name;

    #[Groups('product_show')]
    #[ORM\Column(
        type: Types::TEXT,
        nullable: true,
        options: ['comment' => 'Описание категории']
    )]
    private ?string $description = null;

    #[ORM\Column(
        options: ['comment' => 'Флаг активности категории (отображается ли на сайте)']
    )]
    private bool $isActive;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private Collection $products;

    private function __construct(
        string $name,
        ?string $description,
        bool $isActive
    )
    {
        $this->setName($name);
        $this->setDescription($description);
        $this->setIsActive($isActive);
        $this->products = new ArrayCollection();
    }

    public static function create(
        string $name,
        ?string $description,
        bool $isActive
    ): self
    {
        return new self(
            $name,
            $description,
            $isActive
        );
    }

    public function update(
        Category $category,
        string $name,
        ?string $description,
        bool $isActive
    )
    {
        $category->setName($name);
        $category->setDescription($description);
        $category->setIsActive($isActive);

        return $category;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    private function setName(string $name): void
    {
        Assert::stringNotEmpty($name, "Наименование категории не может быть пустым. Получено: %s");
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    private function setDescription(?string $description): void
    {
        Assert::stringNotEmpty($description, "Описание категории не может быть пустым. Получено: %s");
        $this->description = $description;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    private function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }
}
