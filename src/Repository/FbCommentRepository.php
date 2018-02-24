<?php

namespace App\Repository;

use App\Entity\FbComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FbComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method FbComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method FbComment[]    findAll()
 * @method FbComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FbCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FbComment::class);
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
