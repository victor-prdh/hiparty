<?php

namespace App\Controller;

use App\Entity\Party;
use App\Repository\PartyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartyController extends AbstractController
{
    /**
     *@Route("/api/parties/{lat}/{lng}/{distance}", name="party_near", methods={"GET"})
     *
     * 
     */
    public function partyNear(float $lat, float $lng, int $distance,  PartyRepository $partyRepository): Response
    {
        //select *, ST_Distance_Sphere(point(longitude,latitude), point(3.959227,48.302123)) as distance FROM party

        
        $partys = $partyRepository->findNearParty($lat, $lng, $distance);

        $data = ["status" => "c'est good", 'lat' => $lat, 'lng' => $lng, "party" => $partys];
        return $this->json($data);
    }
}
