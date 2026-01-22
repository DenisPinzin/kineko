<?php

namespace App\Controller;

use App\Entity\Manekineko;
use App\Form\ManekinekoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AjouterController extends AbstractController
{
#[Route('/ajouter', name: 'ajouter')]
public function index(?Manekineko $manekineko, Request $request, EntityManagerInterface $entityManager): Response
{   
    if(!$manekineko){
        $manekineko = new Manekineko;
    }

    $form = $this->createForm(ManekinekoType::class, $manekineko);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $manekineko->setUser($this->getUser());

        $entityManager->persist($manekineko);
        $entityManager->flush();

        return $this->redirectToRoute('galerie');
    }

    return $this->render('ajouter/ajouter.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
