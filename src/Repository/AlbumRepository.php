<?php

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Album>
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    /**
     * @return Query|null Returns an array of Album objects
     */
        public function listAlbum(): ?Query
        {
            return $this->createQueryBuilder('a')
                ->select('a', 's', 'art','p')
                ->innerJoin('a.styles', 's')
                ->innerJoin('a.artist', 'art')
                ->innerJoin('a.pieces', 'p')
                ->orderBy('a.name', 'ASC')
                ->getQuery()
//                ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?Album
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
