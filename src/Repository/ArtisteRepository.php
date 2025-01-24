<?php

namespace App\Repository;

use App\Entity\Artiste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artiste>
 */
class ArtisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artiste::class);
    }

        /**
         * @return Artiste[] Returns an array of Artiste objects
         */
        public function listArtiste(): array
        {
            return $this->createQueryBuilder('a')
                ->select('a', 'alb')
                ->leftJoin('a.albums', 'alb')
                ->orderBy('a.name', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

    /**
     * @return Query|null Returns a Query
     */
    public function listArtisteAdmin(): ?Query
    {
        return $this->createQueryBuilder('a')
            ->select('a', 'alb')
            ->leftJoin('a.albums', 'alb')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
//            ->getResult()
            ;
    }


    /**
     * @return QueryBuilder Returns a QueryBuilder
     */
    public function filterListArtist(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->orderBy('a.name', 'ASC');
    }

    //    public function findOneBySomeField($value): ?Artiste
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
