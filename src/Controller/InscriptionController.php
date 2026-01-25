<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function index( Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response 
    {
        $user = new User();

        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // rôle par défaut
            $user->setRoles(['ROLE_USER']);

            // hash du mot de passe
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // enregistrement en BDD
            $entityManager->persist($user);
            $entityManager->flush();

            // après inscription → redirection login
            return $this->redirectToRoute('app_login');
        }

        return $this->render('inscription/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
