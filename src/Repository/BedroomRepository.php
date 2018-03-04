<?php

namespace App\Repository;

use App\Entity\Bedroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bedroom|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bedroom|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bedroom[]    findAll()
 * @method Bedroom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BedroomRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bedroom::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('b')
            ->where('b.something = :value')->setParameter('value', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
