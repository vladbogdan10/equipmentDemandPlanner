<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function getTotalEquipmentBooked($station)
    {
        return $this->createQueryBuilder('b')
            ->select(
                'b.startDate as date',
                'b.startStation as station',
                "SUM(JSON_EXTRACT(b.equipment, '$.chair')) as chairs",
                "SUM(JSON_EXTRACT(b.equipment, '$.bedSheet')) as bedSheets",
                "SUM(JSON_EXTRACT(b.equipment, '$.sleepingBag')) as sleepingBags",
                "SUM(JSON_EXTRACT(b.equipment, '$.campingTable')) as campingTables",
                "SUM(JSON_EXTRACT(b.equipment, '$.portableToilet')) as portableToilets"
            )
            ->groupBy('b.startDate', 'b.startStation')
            ->where('b.startStation = :city')
            ->setParameter('city', $station)
            ->getQuery()
            ->getResult();
    }

    public function getTotalReturnedEquipment($station)
    {
        return $this->createQueryBuilder('b')
            ->select(
                "b.endDate as date",
                'b.endStation as station',
                "SUM(JSON_EXTRACT(b.equipment, '$.chair')) as chairs",
                "SUM(JSON_EXTRACT(b.equipment, '$.bedSheet')) as bedSheets",
                "SUM(JSON_EXTRACT(b.equipment, '$.sleepingBag')) as sleepingBags",
                "SUM(JSON_EXTRACT(b.equipment, '$.campingTable')) as campingTables",
                "SUM(JSON_EXTRACT(b.equipment, '$.portableToilet')) as portableToilets"
            )
            ->groupBy('b.endDate', 'b.endStation')
            ->where('b.endStation = :city')
            ->setParameter('city', $station)
            ->getQuery()
            ->getResult();
    }
}
