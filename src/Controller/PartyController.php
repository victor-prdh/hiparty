<?php

namespace App\Controller;

use App\Entity\Party;
use App\Entity\User;
use App\Repository\PartyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     *@Route("/api/parties/like", name="party_add_like", methods={"POST"})
     */
    public function partyAddLike(PartyRepository $partyRepository, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
       
        $party = json_decode($request->getContent(), true);
        $userId = $this->getUser()->getId();

        if(isset($party["id"]) && isset($userId)) {
            $message = $partyRepository->partyAddLike($party["id"], $userId);

            $data = ["code" => "200", 'message' => $message];
            return $this->json($data);
        } else {
            $data = ["code" => "404", 'message' => "La fête n'existe pas !"];
            return $this->json($data, 404);
        }
        
        
    }
}
