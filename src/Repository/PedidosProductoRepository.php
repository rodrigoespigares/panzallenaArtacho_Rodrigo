<?php

namespace App\Repository;

use App\Entity\PedidosProducto;
use App\Entity\Producto;
use App\Entity\Pedidos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function anadir($p_id, $ped_id, $cant, EntityManagerInterface $entityManager) {
        // Suponiendo que tienes un repositorio de productos, puedes obtener el producto por su ID
        $ped_prod = new PedidosProducto();

        $producto = $entityManager->getRepository(Producto::class)->find($p_id);
        $pedido = $entityManager->getRepository(Pedidos::class)->find($ped_id);

        if ($producto && $pedido) {
            $ped_prod->setProducto($producto);
            $ped_prod->setPedido($pedido);
            $ped_prod->setUnidades($cant);

            $entityManager->persist($ped_prod);
            $entityManager->flush();
        }
    }

    public function todoProduct(EntityManagerInterface $entityManager, $p_id){
        $productosAsociados=$entityManager->getRepository(PedidosProducto::class)->findBy(['pedido'=>$p_id]);
        $productos=[];
        foreach ($productosAsociados as $productoAsociado){
            $IDproductos = $productoAsociado->getProducto();
            $productos[]=["producto"=>$entityManager->getRepository(Producto::class)->find($IDproductos),"cantidad"=>$productoAsociado->getUnidades()];
        }
        return $productos;
    }
}
