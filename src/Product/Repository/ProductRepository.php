<?php declare(strict_types=1);

namespace App\Product\Repository;

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

    public function add(Product $product): void
    {
        $em = $this->getEntityManager();

        $em->persist($product);
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
            ->select('p')
            ->orderBy('p.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($productsPerPage)
            ->getQuery();

        return $qb->getResult();
    }
}
