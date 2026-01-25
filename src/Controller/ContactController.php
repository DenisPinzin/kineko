<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
    
            $email = (new Email())
                ->from($data['email'])
                ->to('admin@kineko.fr')
                ->subject('Nouveau message de contact')
                ->text(
                    "Nom : {$data['nom']}\n".
                    "Email : {$data['email']}\n\n".
                    "Message :\n{$data['message']}"
                );
    
            // si MAILER_DSN=null://null, ça ne partira pas réellement, mais le code est conforme
            $mailer->send($email);
    
            $this->addFlash('success', 'Votre message a bien été envoyé.');
            return $this->redirectToRoute('contact');
        }
    
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
