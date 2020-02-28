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
    private const ITERATE_BATCH_SIZE = 1000;

    /**
     * Конструктор PlaceRepository.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

    /**
     * Итерирует по всем заведениям.
     *
     * После получения очередного результате предыдущие могут быть исключены из ObjectManager.
     *
     * @return iterable|Place[] заведения
     */
    public function iterateAll(): iterable
    {
        $latestId = 0;
        $placesLeft = true;

        while ($placesLeft) {
            $placesLeft = false;
            $query = $this->createQueryBuilder('p')
                ->where('p.id > :id')
                ->setParameter('id', $latestId)
                ->orderBy('p.id', 'ASC')
                ->setMaxResults(self::ITERATE_BATCH_SIZE)
                ->getQuery();

            foreach ($query->iterate() as $placeInfo) {
                /** @var Place $place */
                $place = $placeInfo[0];
                $latestId = $place->getId();
                $placesLeft = true;

                yield $place;
            }

            $this->clear();
        }
    }
}
