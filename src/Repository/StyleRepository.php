<?php

namespace App\Repository;

use App\Entity\Style;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Style>
 */
class StyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Style::class);
    }

    /**
     * @return Query|null Returns Query or null
     */
    public function listStyle(): ?Query
    {
        return $this->createQueryBuilder('s')
            ->select('s', 'alb')
            ->leftJoin('s.albums', 'alb')
            ->orderBy('s.name', 'ASC')
            ->getQuery();
    }

    /**
     * @return QueryBuilder Returns a QueryBuilder
     */
    public function filterListStyle(): QueryBuilder
    {
        return $this->createQueryBuilder('s')
            ->select('s')
            ->orderBy('s.name', 'ASC');
    }

    //    public function findOneBySomeField($value): ?Style
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
