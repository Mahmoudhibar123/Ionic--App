<?php

namespace App\Controller;

use App\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{

    /**
     * @Route("/{id}", name="supprimer_commentaire")
     */
    public function supprimer(Request $request,$id)
    {
        $commentaire = $this->getDoctrine()->getRepository(Commentaire::class)->find($id);
      $em = $this->getDoctrine()->getManager();
            $em->remove($commentaire);
            $em->flush();
return $this->redirectToRoute('afficher_livre', array(
                'id' => $commentaire->getLivre()
            ));
    }    
}
