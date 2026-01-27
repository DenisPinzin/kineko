<?php

namespace App\Controller;

use App\Entity\Manekineko;
use App\Form\ManekinekoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Commentaire;
use App\Form\CommentaireType;

final class ManekinekoController extends AbstractController
{
    //MODIFIER

    //Manekineko existe déja

    #[Route('/manekineko/{id}/edit', name: 'manekineko_edit')]
    public function edit(Manekineko $manekineko, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        //CHATGPT START
        if ($manekineko->getUser() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Tu ne peux pas modifier cette carte.");
        }

        $form = $this->createForm(ManekinekoType::class, $manekineko);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Carte modifiée avec succès');
            return $this->redirectToRoute('galerie');
        }

        return $this->render('manekineko/edit.html.twig', [
            'form' => $form->createView(),
            'manekineko' => $manekineko,
        ]);
    }

    //SUPPRIMER

    #[Route('/manekineko/{id}/delete', name: 'manekineko_delete', methods: ['POST'])]
    public function delete(Manekineko $manekineko, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($manekineko->getUser() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Tu ne peux pas supprimer cette carte.");
        }

        if ($this->isCsrfTokenValid('delete'.$manekineko->getId(), (string) $request->request->get('_token'))) {
            $em->remove($manekineko);
            $em->flush();

            $this->addFlash('success', 'Carte supprimée');
        }

        return $this->redirectToRoute('galerie');
    }


    //DETAIL

    #[Route('/manekineko/{id}', name: 'manekineko_show', methods: ['GET', 'POST'])]
    public function show(Manekineko $manekineko, Request $request, EntityManagerInterface $em): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted() && $form->isValid()) {

            $commentaire->setUser($this->getUser());
            $commentaire->setManekineko($manekineko);

            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('manekineko_show', ['id' => $manekineko->getId()]);
        }

        return $this->render('manekineko/show.html.twig', [
            'manekineko' => $manekineko,
            'commentForm' => $form->createView(),
        ]);
    }

}
