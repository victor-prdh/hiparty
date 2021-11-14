<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {

        $newsletter = new Newsletter;
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            date_default_timezone_set('Europe/Paris');
            $newsletter->setRegisterDate(new \DateTime());

            $exist = $this->getDoctrine()->getRepository(Newsletter::class)->findOneBy(['email' => $newsletter->getEmail()]);
            if ($exist === null) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newsletter);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Inscription à la newsletter confirmé !'
                );
            } else {
                $this->addFlash(
                    'error',
                    'Vous êtes déjà inscrit à notre newsletter !'
                );
            }


            return $this->redirectToRoute('home');
        }

        return $this->renderForm(
            'home/index.html.twig',
            ['form' => $form]
        );
    }
}
