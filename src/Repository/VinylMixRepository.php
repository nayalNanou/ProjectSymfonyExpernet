<?php
namespace App\Repository;

use App\Entity\VinylMix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VinylMixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VinylMix::class);
    }

    /**
     * @return VinylMix[] Returns an array of Fruit objects
     */
    public function filterByGenre($genre): array
    {
        $queryBuilder = $this->createQueryBuilder('v');

        if ($genre) {
            $queryBuilder->andWhere('v.genre = :genre')
                    ->setParameter('genre', $genre);
        }

        return $queryBuilder
            ->orderBy('v.votes', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}