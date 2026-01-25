<?php

namespace App\Controller;

use App\Repository\ManekinekoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManekinekoRepository $manekinekoRepository): Response
    {
        $lastManekinekos = $manekinekoRepository->findBy(
            [],                 
            ['id' => 'DESC'],   
            4                   
        );

        return $this->render('home/index.html.twig', [
            'lastManekinekos' => $lastManekinekos,
        ]);
    }
}
