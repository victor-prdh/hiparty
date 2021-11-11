<?php

namespace App\Controller;

use App\Entity\Party;
use App\Entity\User;
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
    public function partyNear(float $lat, float $lng, int $distance,  PartyRepository $partyRepository)
    {
        

        
        $partys = $partyRepository->findNearParty($lat, $lng, $distance);

        $data = ["code" => "200", 'lat' => $lat, 'lng' => $lng, "party" => $partys];
        return $this->json($data);
    }

    /**
     *@Route("/api/parties/liked", name="party_liked", methods={"GET"})
     */
    public function partyLiked(PartyRepository $partyRepository)
    {
        
       
        $jwtUser = $this->getUser();
        
        $partys = $partyRepository->getLikedParty($jwtUser->getId());
        
        

        $data = ["code" => "200", "party" => $partys];
        return $this->json($data);
    }
}
