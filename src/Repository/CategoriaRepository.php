<?php

namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoria>
 *
 * @method Categoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoria[]    findAll()
 * @method Categoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    /** Función para buscar las categorias catalogadas */
    public function findCatalogados() {
        return $this->createQueryBuilder('c')
        ->andWhere('c.descatalogado = :descatalogado')
        ->setParameter('descatalogado', false)
        ->getQuery()
        ->getResult();
    }
    /** Función para buscar las categorias catalogadas y que además tengan productos*/
    public function extract(){
        // $entityManager = $this->getDoctrine()->getManager();
        $query = $this->createQueryBuilder('c')
        ->innerJoin('App\Entity\Producto', 'p', 'WITH', 'c.codCat = p.categoria')
        ->andWhere('c.descatalogado = :descatalogado')
        ->setParameter('descatalogado', false)
        ->getQuery();

        $categorias = $query->getResult();
        // Haz algo con las categorías obtenidas, por ejemplo, devuélvelas o realiza alguna operación.
        return $categorias;
    }
}
