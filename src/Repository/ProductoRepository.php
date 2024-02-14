<?php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Producto>
 *
 * @method Producto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producto[]    findAll()
 * @method Producto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    /** Fuuncion para extraer los productos que no estan descatalogados */
    public function extract()
    {
        return $this->findBy(['descatalogado' => false], null, null);
    }
    public function restar($id, $resta, $entityManager){
        $productoRepository = $entityManager->getRepository(Producto::class);
        $producto = $productoRepository->find($id);
        $nuevaCantidad = $producto->getStock() - $resta;
        $producto->setStock($nuevaCantidad);
        $entityManager->persist($producto);
        $entityManager->flush();
    }

}
