<?php

namespace App\Repository;

use App\Entity\Party;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Party|null find($id, $lockMode = null, $lockVersion = null)
 * @method Party|null findOneBy(array $criteria, array $orderBy = null)
 * @method Party[]    findAll()
 * @method Party[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Party::class);
    }

     /**
      * @return Party[] Returns an array of Party objects
     */
    
    public function findNearParty($lat, $lng, $distance)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select * FROM party where ST_Distance_Sphere(point(longitude,latitude), point(?,?))/1000 < ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $lng);
        $stmt->bindValue(2, $lat);
        $stmt->bindValue(3, $distance);

        $stmt->execute();
        

        return $stmt->fetchAll();
    }
    

    public function test($sqlDistance, $distance)
    {
        return $this->createQueryBuilder('')
            ->andWhere("" . $sqlDistance . " < :distance")
            ->setParameter('distance', $distance)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Party
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
