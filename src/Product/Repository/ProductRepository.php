<?php declare(strict_types=1);

namespace App\Product\Repository;

use App\Category\Entity\Category;
use App\Product\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function addProduct(Product $product): void
    {
        $em = $this->getEntityManager();

        $em->persist($product);
        $em->flush();
    }

    /** @param Product[] $products */
    public function addProducts(array $products): void
    {
        $em = $this->getEntityManager();

        foreach ($products as $product) {
            $em->persist($product);
        }

        $em->flush();
    }

    public function findBySlug(string $slug): ?Product
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function findBySku(int $sku): ?Product
    {
        return $this->findOneBy(['sku' => $sku]);
    }

    public function findByPage(int $page, int $productsPerPage): array
    {
        $offset = ($page - 1) * $productsPerPage;

        $qb = $this->createQueryBuilder('p')
            ->select('p', 'c')
            ->leftJoin('p.category', 'c')
            ->orderBy('p.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($productsPerPage)
            ->getQuery();

        return $qb->getResult();
    }

    public function findByCategory(Category $category): array
    {
        return $this->findBy(['category' => $category]);
    }

    public function remove(Product $product): void
    {
        $em = $this->getEntityManager();

        $em->remove($product);
        $em->flush();
    }

    public function findByIds(array $ids): array
    {
        return $this->findBy(['id' => $ids]);
    }
}
