<?php

namespace App\Repository;

use App\Entity\EjerciciosRutina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method EjerciciosRutina|null find($id, $lockMode = null, $lockVersion = null)
 * @method EjerciciosRutina|null findOneBy(array $criteria, array $orderBy = null)
 * @method EjerciciosRutina[]    findAll()
 * @method EjerciciosRutina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EjerciciosRutinaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        parent::__construct($registry, EjerciciosRutina::class);
        $this->manager = $manager;
    }
   
    
    function saveEjercicioRutina(EjerciciosRutina $ejerciciosRutina)
    {
        $this->manager->persist($ejerciciosRutina);
        $this->manager->flush();
    }
    
    function removeEjercicioRutina(EjerciciosRutina $ejerciciosRutina)
    {
        $this->manager->remove($ejerciciosRutina);
        $this->manager->flush();
    }

    // /**
    //  * @return EjerciciosRutina[] Returns an array of EjerciciosRutina objects
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
    public function findOneBySomeField($value): ?EjerciciosRutina
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
