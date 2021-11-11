<?php

namespace App\Repository;

use App\Entity\Party;
use DateTime;
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
        date_default_timezone_set('Europe/Paris');
    }

    /**
     * @return Party[] Returns an array of Party objects
     */

    public function findNearParty($lat, $lng, $distance)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "SELECT party.id, party.name, description, price, photo, nb_places, partytime, lieux, is_majeur, is_outdoor, is_reserved, reserv_desc, user.name AS orga_name, user.id AS orga_id, user.firstname AS orga_firstname FROM party JOIN user ON party.organisateur_id = user.id where ST_Distance_Sphere(point(longitude,latitude), point(?,?))/1000 < ? AND partytime > NOW() ORDER BY partytime ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $lng);
        $stmt->bindValue(2, $lat);
        $stmt->bindValue(3, $distance);

        $stmt->execute();


        return $stmt->fetchAll();
    }


    public function getLikedParty($userId)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "SELECT * FROM `party_user` WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $userId);


        $stmt->execute();

        $partys =$stmt->fetchAll();
        $data = [];

        foreach ($partys as $party) {
            $sql = "SELECT party.id, party.name, description, price, photo, nb_places, partytime, lieux, is_majeur, is_outdoor, is_reserved, reserv_desc, user.name AS orga_name, user.id AS orga_id, user.firstname AS orga_firstname FROM party JOIN user ON party.organisateur_id = user.id WHERE party.id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $party["party_id"]);
            $stmt->execute();
            $p = $stmt->fetchAll();
            
            if(new DateTime($p[0]["partytime"]) > new DateTime()){
                $data[] = $p[0];
            }
            
        }
        
        $keys = array_column($data, 'partytime');
        array_multisort($keys, SORT_ASC, $data);
        
        return $data;
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
