<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="index_livre",methods={"GET"})
     */
    public function index()
    {
        $livres = $this->getDoctrine()->getRepository(Livre::class)->findAll();
          return $this->render('livre/index.html.twig', 
              array(
                'livres' => $livres
            ));
    }

    /**
     * @Route("/ajout", name="ajout_livre",methods={"GET", "POST"})
     */
    public function ajout(Request $request)
    {
        $livre = new Livre();

          $form = $this->createFormBuilder($livre)
            ->add('Titre')
          ->add('Description')

            ->add('Image', FileType::class)
            ->add('Pdf', FileType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
       //https://symfony.com/doc/current/controller/upload_file.html

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('Image')->getData();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('livres_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $livre->setImage($fileName);

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('Pdf')->getData();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('livres_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $livre->setPdf($fileName);
       $em = $this->getDoctrine()->getManager();
             $em->persist($livre);
            $em->flush();

            return $this->redirectToRoute('index_livre');
        }

        return $this->render('livre/ajout.html.twig', 
              array(
            'livre' => $livre,
            'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/{id}", name="afficher_livre",methods={"GET", "POST"})
     */
    public function afficher(Request $request, $id)
    {
        $livre = $this->getDoctrine()->getRepository(Livre::class)->find($id);
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('supprimer_livre', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm(); 
        $commentaire = new Commentaire();    

        //////////////////////////////////////////////////



        
        $form_commentaire = $this->createFormBuilder($commentaire)
            ->add('Utilisateur')
            ->add('Contenu')
            
            ->getForm();
        $form_commentaire->handleRequest($request);    
       if ($form_commentaire->isSubmitted() && $form_commentaire->isValid()) {
       $commentaire->setLivre($livre);
       $em = $this->getDoctrine()->getManager();
             $em->persist($commentaire);
            $em->flush();
            
              return $this->redirectToRoute('afficher_livre', array(
                'id' => $id
            ));
        }

        return $this->render('livre/afficher.html.twig', 
                  array(
                'livre' => $livre,
                'form' => $form->createView(),
                'form_commentaire' => $form_commentaire->createView()
            ));
    }

    /**
     * @Route("/{id}/modifier", name="modifier_livre",methods={"GET", "POST"})
     */
    public function modifier(Request $request, $id)
    {
        $livre = $this->getDoctrine()->getRepository(Livre::class)->find($id);
        // https://symfony.com/doc/current/controller/upload_file.html
        //When creating a form to edit an already persisted item, the file form type still 
        // expects a File instance. As the persisted entity now contains only the relative 
        // file path, you first have to concatenate the configured upload path with 
        // the stored filename and create a new File class:        
        $livre->setImage(
            new File($this->getParameter('livres_directory').'/'.$livre->getImage())
        );   
        $livre->setPdf(
            new File($this->getParameter('livres_directory').'/'.$livre->getPdf())
        );              
          $form = $this->createFormBuilder($livre)
            ->add('Titre')
          ->add('Description')
            ->add('Image', FileType::class)


            ->add('Pdf', FileType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
       //https://symfony.com/doc/current/controller/upload_file.html
             if($form->get('Image')->getData()){
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('Image')->getData();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('livres_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $livre->setImage($fileName);
            }
            if($form->get('Pdf')->getData()){
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('Pdf')->getData();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('livres_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $livre->setPdf($fileName);     
            }

            $this->getDoctrine()->getManager()->flush();

              return $this->redirectToRoute('afficher_livre', array(
                'id' => $livre->getId()
            ));
        }

        return $this->render('livre/modifier.html.twig', 
            array(
                'livre' => $livre,
            'form' => $form->createView(),
        )
        );
    }

    /**
     * @Route("/{id}", name="supprimer_livre",methods={"DELETE"})
     */
    public function supprimer(Request $request,$id)
    {
        $livre = $this->getDoctrine()->getRepository(Livre::class)->find($id);
      $em = $this->getDoctrine()->getManager();
            $em->remove($livre);
            $em->flush();
return $this->redirectToRoute('index_livre');
    }
}
