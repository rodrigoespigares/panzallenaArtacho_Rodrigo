<?php

namespace App\Repository;

use App\Entity\PedidosProducto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PedidosProducto>
 *
 * @method PedidosProducto|null find($id, $lockMode = null, $lockVersion = null)
 * @method PedidosProducto|null findOneBy(array $criteria, array $orderBy = null)
 * @method PedidosProducto[]    findAll()
 * @method PedidosProducto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidosProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PedidosProducto::class);
    }

//    /**
//     * @return PedidosProducto[] Returns an array of PedidosProducto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PedidosProducto
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
