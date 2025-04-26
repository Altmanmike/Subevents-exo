<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Registration;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Registration>
 *  
 * @method Registration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Registration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Registration[]    findAll()
 * @method Registration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Registration::class);
    }
    
    /**
     * @param mixed $entity
     * @param mixed $flush
     * @return void
     */
    public function add(Registration $entity, bool $flush = false): void
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
    public function remove(Registration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * @param mixed $event
     * @return mixed
     */
    public function countRegistrationsByEvent(Event $event): mixed
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.event = :event')
            ->setParameter('event', $event)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    /**
     * @param mixed $user
     * @return mixed
     */
    public function countRegistrationsByUser(User $user): mixed
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param mixed $event
     * @return Registration[] Returns an array of Registration object
     */
    public function getRegistrationsByEvent(Event $event): array
    {
        return $this->createQueryBuilder('r')            
            ->where('r.event = :event')
            ->setParameter('event', $event)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Registration[] Returns an array of Registration objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Registration
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
