<?php

namespace App\Repository;

use App\Entity\Style;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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
     * @return Query|null Returns an array of Style objects
     */
    public function listStyle(): ?Query
    {
        return $this->createQueryBuilder('s')
            ->select('s', 'alb')
            ->leftJoin('s.albums', 'alb')
            ->orderBy('s.name', 'ASC')
            ->getQuery();
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
