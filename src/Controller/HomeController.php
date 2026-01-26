<?php

namespace App\Controller;

// je recupere ce qu'il y a dans la class ManekinekoRepository
use App\Repository\ManekinekoRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    //$manekinekoRepository correspond à la variable qui recupere les éléments dans la class ManekinekoRepository
    public function index(ManekinekoRepository $manekinekoRepository): Response
    {
        $lastManekinekos = $manekinekoRepository->findBy(
            [],                 
            ['id' => 'DESC'],   
            4                   
        );

        // je crée une variable avec sa valeur
        $tortue = "tortue";

        return $this->render('home/index.html.twig', [
            'lastManekinekos' => $lastManekinekos,

            //Je recupere pour importer dans la vue(twig) la variable $tortue 
            'animal' => $tortue
        ]);
    }
}
