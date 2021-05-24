<?php

namespace App\Repository;

use App\Entity\Estadistica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @method Estadistica|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estadistica|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estadistica[]    findAll()
 * @method Estadistica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadisticaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        parent::__construct($registry, Estadistica::class);
        $this->manager = $manager;
    }

    function saveEstadistica(Estadistica $estadistica) 
     {
        $this->manager->persist($estadistica);
        $this->manager->flush();
    }
    
     function removeEstadistica(Estadistica $estadistica)
    {
        $this->manager->remove($estadistica);
        $this->manager->flush();
    }

    // /**
    //  * @return Estadistica[] Returns an array of Estadistica objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Estadistica
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
