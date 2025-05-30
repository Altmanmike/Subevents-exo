<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *  
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }
    
    /**
     * @param mixed $entity
     * @param mixed $flush
     * @return void
     */
    public function add(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * @param mixed $entity
     * @param mixed $flush
     * @return void
     */
    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Event[] Returns an array of Event objects
     */
    public function findUpcomingEvents(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
  
    /**
     * @param mixed $title
     * @return Event Returns an Event object
     */
    public function findEventByTitle($title): ?Event
    {
        return $this->createQueryBuilder('e')
            ->Where('e.title = :title')
            ->setParameter('title', $title)            
            ->getQuery()            
            ->getOneOrNullResult();
    }

    /**
     * @param mixed $startAt
     * @return Event[] Returns an array of Event objects
     */
    public function findComingEventsAtDate($startAt): array
    {
        return $this->createQueryBuilder('e')
            ->where('SUBSTRING(e.startAt, 1, 10) = :datePart')
            ->setParameter('datePart', $startAt)
            ->orderBy('e.id', 'ASC')                
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
