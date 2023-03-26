<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Booking>
 *
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

    public function save(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * Get next booking by customer
     *
     * @param [type] $value
     * @return array
     */
    public function findNextBookingOneBy($value) : array
    {
        return $this->createQueryBuilder('b')
                            ->andWhere('b.customer = :val')
                            ->andWhere('b.Date >= :val2')
                            ->setParameter('val', $value)
                            ->setParameter('val2', Date('Y-m-d'))
                            ->getQuery()
                            ->getResult();
    }



/**
 * Sum of booking in lunch and dinner 
 *
 * @param [type] $time (for lunch or dinner)
 * @param [type] $now   (day reference)
 * @param [type] $interval  (period for getting booking)
 * @return array
 */
    public function countBooking($time, $dateref, $interval):array
    {     
        return $this->createQueryBuilder('b')
                        ->select('SUM( CASE WHEN b.time < :val1 THEN b.numberPerson ELSE 0 END) AS LUNCH')
                        ->addSelect('SUM( CASE WHEN b.time > :val1 THEN b.numberPerson ELSE 0 END) AS DINNER')
                        ->Where('b.Date >= :val2')
                        ->andWhere('b.Date <= :val3')
                        ->setParameter('val1', $time)
                        ->setParameter('val2', $dateref)
                        ->setParameter('val3', $interval)
                        ->getQuery()
                        ->getResult();          
    }

    /**
     * Sum of booking in lunch and dinner group by Date
     *
     * @param [type] $time
     * @param [type] $now
     * @param [type] $interval
     * @return array
     */
    public function countGroupBooking($time, $dateref, $interval):array
    {     
        return $this->createQueryBuilder('b')
                        ->select('SUM( CASE WHEN b.time < :val1 THEN b.numberPerson ELSE 0 END) AS LUNCH')
                        ->addSelect('SUM( CASE WHEN b.time > :val1 THEN b.numberPerson ELSE 0 END) AS DINNER')
                        ->addSelect('b.Date')
                        ->andWhere('b.Date < :val2 ')
                        ->andWhere('b.Date >= :val3')
                        ->setParameter('val1', $time)
                        ->setParameter('val2', $dateref)
                        ->setParameter('val3', $interval)
                        ->groupBy('b.Date')
                        ->getQuery()
                        ->getResult();          
    }

    /**
     * Count reservation for lunch service
     *
     * @param [type] $day
     * @param [type] $ref
     * @return integer|null
     */
    public function countByLunchDay($day, $ref):?int
    {
        return $this->createQueryBuilder('b')
                ->select('count(b.id)')
                ->where('b.Date = :val1')
                ->andWhere('b.time < :val2')
                ->setParameter('val1', $day)
                ->setParameter('val2', $ref)
                ->getQuery()
                ->getSingleScalarResult();
    }

    /**
     * count reservation for dinner service
     *
     * @param [type] $day
     * @param [type] $ref
     * @return integer|null
     */
    public function countByDinnerDay($day, $ref):?int
    {
        return $this->createQueryBuilder('b')
                ->select('count(b.id)')
                ->where('b.Date = :val1')
                ->andWhere('b.time > :val2')
                ->setParameter('val1', $day)
                ->setParameter('val2', $ref)
                ->getQuery()
                ->getSingleScalarResult();
    }

}
