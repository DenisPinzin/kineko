<?php

namespace App\Controller;

use App\Repository\ManekinekoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GalerieController extends AbstractController
{
    #[Route('/galerie', name: 'galerie')]
    public function index(ManekinekoRepository $manekinekoRepository): Response
    {
        $manekinekos = $manekinekoRepository->findBy([], ['id' => 'DESC']);

        return $this->render('galerie/galerie.html.twig', [
            'manekinekos' => $manekinekos,
        ]);
    }
}
