<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Репозиторий заведений в городе.
 *
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

    /**
     * Возвращает заведения с id больше заданного в порядке возрастания id.
     *
     * @param int $previousId id заведения, после которого искать
     * @param int $limit максимальное количество заведений в результате
     *
     * @return Place[] найденные заведения
     */
    public function findWithGreaterIdOrderedById(int $previousId, int $limit)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id > :id')
            ->setParameter('id', $previousId)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
