<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(ManagerRegistry $doctrine,
                          Request $request,
                          MailerService $mailerService
    ): Response
    {

        $contact = null;

        $form = $this->createForm(ContactType::class, $contact );
        $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $mailerService->sendMail( $contact['name'],$contact['userEmail'], $contact['subject'], $contact['description']);
            $this->addFlash('success1', 'Your message has been sent successfully!
            We will contact you as soon as possible.');
           return $this->redirectToRoute('contact', ['success' => true]);
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
