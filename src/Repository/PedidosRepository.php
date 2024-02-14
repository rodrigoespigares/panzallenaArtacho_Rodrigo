<?php

namespace App\Repository;

use App\Entity\Pedidos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\PedidosProducto;

/**
 * @extends ServiceEntityRepository<Pedidos>
 *
 * @method Pedidos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pedidos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pedidos[]    findAll()
 * @method Pedidos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, )
    {
        parent::__construct($registry, Pedidos::class);
    }

//    /**
//     * @return Pedidos[] Returns an array of Pedidos objects
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

//    public function findOneBySomeField($value): ?Pedidos
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
/** Función para añadir un pedido */
public function anadir($data,$carrito, RestauranteRepository $restauranteRepository, EntityManagerInterface $entityManager, ProductoRepository $productoRepository) {
    $restauranteId = $data['restaurante_id'];
    
    $restaurante = $restauranteRepository->find($restauranteId);

    // Crear una nueva instancia de la entidad Pedidos
    $pedido = new Pedidos();
    $pedido->setRestaurante($restaurante);
    $fecha = new \DateTime($data['fecha']);
    $pedido->setFecha($fecha);
    $pedido->setEnviado(false);

    // Crear el pedido en la base de datos
    $entityManager->persist($pedido);
    $entityManager->flush();
    foreach ($carrito as $value) {
        $pedidosProductoRepository = $entityManager->getRepository(PedidosProducto::class);
        $pedidosProductoRepository->anadir($value['id'],$pedido->getCodPed(),$value['cantidad'],$entityManager);
        $productoRepository->restar($value['id'],$value['cantidad'],$entityManager);
    }

    return $pedido->getCodPed();
}
}
