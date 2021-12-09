<?php

namespace App\Controller;

use App\Entity\Verification;
use App\Form\VerificationType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerifyController extends AbstractController
{
    /**
     * @Route("/verifier", name="verify")
     */
    public function index(Request $request): Response
    {
        $verification = new Verification();

        $form = $this->createForm(VerificationType::class, $verification);
        if($form->isSubmitted() && $form->isValid()){
            $verification->setTraitement(0);
            $verification->setCreatedAt(new \DateTimeImmutable());

        }

        return $this->renderForm('verify/index.html.twig', [
            'form' => $form
        ]);
    }
}
