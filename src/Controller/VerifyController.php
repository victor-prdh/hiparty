<?php

namespace App\Controller;

use App\Entity\Verification;
use App\Form\VerificationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerifyController extends AbstractController
{
    /**
     * @Route("/verifier", name="verify")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $isPendingVerif = $doctrine->getRepository(Verification::class)->findOneBy(["FromUser" => $this->getUser()->getId(), "traitement" => 0]);


        if ($isPendingVerif) {
            if($isPendingVerif->getTraitement() == 0){
                $this->addFlash('error', 'Vous avez déjà une demande en cours de traitement.');
                return $this->redirect($this->generateUrl('dashboard'));
            }
            
        }

        if (in_array('ROLE_CONTRIB', $this->getUser()->getRoles(), true)) {
            $this->addFlash('success', 'Vous êtes déjà vérifié.');
            return $this->redirect($this->generateUrl('dashboard'));
        }
        

        $verification = new Verification();

        $form = $this->createForm(VerificationType::class, $verification);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $verification->setTraitement(0);
            $verification->setCreatedAt(new \DateTimeImmutable());
            $verification->setFromUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($verification);
            $em->flush();

            $this->addFlash('success', 'Votre demande a bien été prise en compte. Vous recevrez une réponse par mail.');
            return $this->redirect($this->generateUrl('dashboard'));
        }

        return $this->renderForm('verify/index.html.twig', [
            'form' => $form
        ]);
    }
}
