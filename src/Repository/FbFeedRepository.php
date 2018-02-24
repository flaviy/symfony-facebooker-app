<?php

namespace App\Repository;

use App\Entity\FbFeed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FbFeed|null find($id, $lockMode = null, $lockVersion = null)
 * @method FbFeed|null findOneBy(array $criteria, array $orderBy = null)
 * @method FbFeed[]    findAll()
 * @method FbFeed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FbFeedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FbFeed::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('f')
            ->where('f.something = :value')->setParameter('value', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
