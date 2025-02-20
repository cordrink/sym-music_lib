<?php

namespace App\Repository;

use App\Entity\Album;
use App\Model\FilterAlbum;
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
    public function listAlbum(FilterAlbum $filter): ?Query
    {
        $query = $this->createQueryBuilder('a')
            ->select('a', 's', 'art', 'p')
            ->leftJoin('a.styles', 's')
            ->leftJoin('a.artist', 'art')
            ->leftJoin('a.pieces', 'p')
            ->orderBy('a.name', 'ASC');

        if (!empty($filter->name)) {
            $query->andWhere('a.name like :name')
                ->setParameter('name', "%{$filter->name}%");
        }

        if (!empty($filter->artist)) {
            $query->andWhere('a.artist = :artist')
                ->setParameter('artist', $filter->artist);
        }

        /*if (0 !== count($filter->styles)) {
            foreach ($filter->styles as $key => $style) {
                $query->andWhere(":style$key MEMBER OF a.styles")
                    ->setParameter("style$key", $style);
            }
        }*/

        if (0 !== count($filter->styles)) {
            $conditions = [];
            foreach ($filter->styles as $key => $style) {
                $conditions[] = $query->expr()->isMemberOf(":style$key", "a.styles");
                $query->setParameter("style$key", $style);
            }
            $blockConditionOr = $query->expr()->orX()->addMultiple($conditions);
            $query->andWhere($blockConditionOr);
        }

        return $query->getQuery();
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
