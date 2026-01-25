<?php

namespace App\Controller;

use App\Entity\Fabriquant;
use App\Entity\Manekineko;
use App\Form\ManekinekoType;
use App\Repository\FabriquantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AjouterController extends AbstractController
{
    #[Route('/ajouter', name: 'ajouter')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        FabriquantRepository $fabRepo
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $manekineko = new Manekineko();
        $form = $this->createForm(ManekinekoType::class, $manekineko);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $selectedFab = $form->get('fabriquant')->getData(); // Fabriquant|null
            $nomNouveau  = trim((string) $form->get('nouveauFabriquant')->getData());

            // "inconnu" est la valeur par défaut => si l'input est rempli, il doit pouvoir la remplacer
            $selectedIsInconnu = $selectedFab && mb_strtolower((string) $selectedFab->getNom()) === 'inconnu';

            // Si l'input est rempli ET (pas de select OU select = inconnu) => l'input gagne
            if ($nomNouveau !== '' && ($selectedFab === null || $selectedIsInconnu)) {

                $nomNouveau = mb_strtolower($nomNouveau);

                // Existe déjà ?
                $existing = $fabRepo->findOneBy(['nom' => $nomNouveau]);

                if ($existing) {
                    // Message clair + stop
                    $form->get('nouveauFabriquant')->addError(new FormError(
                        'Ce fabriquant existe déjà. Sélectionne-le dans la liste déroulante.'
                    ));

                    return $this->render('ajouter/ajouter.html.twig', [
                        'form' => $form->createView(),
                    ]);
                }

                // Création autorisée
                $fab = new Fabriquant();
                $fab->setNom($nomNouveau);

                $entityManager->persist($fab);
                $manekineko->setFabriquant($fab);

            } else {
                // Sinon => priorité au select
                $manekineko->setFabriquant($selectedFab);
            }

            // Sécurité (au cas où)
            if ($manekineko->getFabriquant() === null) {
                $form->get('fabriquant')->addError(new FormError(
                    'Choisis un fabriquant ou saisis-en un nouveau.'
                ));

                return $this->render('ajouter/ajouter.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            // Enregistrement du Manekineko
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
