<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livre;
use App\Entity\Evenement;
use Symfony\Component\HttpFoundation\Request;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();
        $livres = $this->getDoctrine()->getRepository(Livre::class)->findAll();      
        return $this->render('accueil/index.html.twig', [
            'livres' => $livres,
            'evenements' => $evenements,
        ]);
    }
    /**
     * @Route("/rechercher", name="recherche")
     */
    public function recherche(Request $request)
    {
        $searchterm = $request->get('searchterm');
        //https://stackoverflow.com/questions/8164682/doctrine-and-like-query
         $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT o FROM App:Livre o WHERE o.Titre like :searchterm")
        ->setParameter('searchterm', '%'.$searchterm.'%');
        $livres = $query->getResult(); 
          return $this->render('livre/index.html.twig', 
              array(
                'livres' => $livres
            ));
    }    
}
