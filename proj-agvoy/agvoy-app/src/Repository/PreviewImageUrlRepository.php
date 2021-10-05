<?php

namespace App\Repository;

use App\Entity\PreviewImageUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PreviewImageUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreviewImageUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreviewImageUrl[]    findAll()
 * @method PreviewImageUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreviewImageUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PreviewImageUrl::class);
    }

    // /**
    //  * @return PreviewImageUrl[] Returns an array of PreviewImageUrl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PreviewImageUrl
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
