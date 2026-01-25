<?php

namespace App\Controller;

use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class CommentaireController extends AbstractController
{
    #[Route('/commentaire/{id}/delete', name: 'commentaire_delete', methods: ['POST'])]
    public function delete(Commentaire $commentaire, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        // ✅ autorisé si auteur du commentaire OU propriétaire du manekineko
        if ($user !== $commentaire->getUser() && $user !== $commentaire->getManekineko()->getUser()) {
            throw new AccessDeniedException("Tu ne peux pas supprimer ce commentaire.");
        }

        if ($this->isCsrfTokenValid('delete_comment'.$commentaire->getId(), (string) $request->request->get('_token'))) {
            $manekinekoId = $commentaire->getManekineko()->getId();

            $em->remove($commentaire);
            $em->flush();

            $this->addFlash('success', 'Commentaire supprimé ✅');

            return $this->redirectToRoute('manekineko_show', ['id' => $manekinekoId]);
        }

        return $this->redirectToRoute('manekineko_show', [
            'id' => $commentaire->getManekineko()->getId(),
        ]);
    }
}
