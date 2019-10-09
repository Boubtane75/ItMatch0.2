<?php

namespace App\Repository;

use App\Entity\Trajet;
use App\Entity\trajetSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Trajet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trajet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trajet[]    findAll()
 * @method Trajet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }

    /**
     * @array $critaire
     */
    public function findByExampleField($critaire)
    {
        return $this->createQueryBuilder('t')
            ->where('t.LieuDepart = :LieuDepart')
            ->setParameter('LieuDepart',$critaire['LieuDepart'])
            ->andWhere('t.LieuArrived = :LieuArrived')
            ->setParameter('LieuArrived',$critaire['LieuArrived'])
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Trajet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
