<?php

namespace App\Controller;

use App\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="index_evenement",methods={"GET"})
     */
    public function index()
    {
        $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();
          return $this->render('evenement/index.html.twig', 
              array(
                'evenements' => $evenements
            ));
    }

    /**
     * @Route("/ajout", name="ajout_evenement",methods={"GET", "POST"})
     */
    public function ajout(Request $request)
    {
        $evenement = new Evenement();

          $form = $this->createFormBuilder($evenement)
            ->add('Titre')
             ->add('Description')
            ->add('Image', FileType::class)
              ->add('date')
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
                    $this->getParameter('evenements_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $evenement->setImage($fileName);


            
       $em = $this->getDoctrine()->getManager();
             $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('index_evenement');
        }

        return $this->render('evenement/ajout.html.twig', 
              array(
            'evenement' => $evenement,
            'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/{id}", name="afficher_evenement",methods={"GET"})
     */
    public function afficher($id)
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('supprimer_evenement', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm();
        return $this->render('evenement/afficher.html.twig', 
                  array(
                'evenement' => $evenement,
                'form' => $form->createView()
            ));
    }

    /**
     * @Route("/{id}/modifier", name="modifier_evenement",methods={"GET", "POST"})
     */
    public function modifier(Request $request, $id)
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        // https://symfony.com/doc/current/controller/upload_file.html
        //When creating a form to edit an already persisted item, the file form type still 
        // expects a File instance. As the persisted entity now contains only the relative 
        // file path, you first have to concatenate the configured upload path with 
        // the stored filename and create a new File class:        
        $evenement->setImage(
            new File($this->getParameter('evenements_directory').'/'.$evenement->getImage())
        );          
          $form = $this->createFormBuilder($evenement)
            ->add('Titre')
             ->add('Description')
            ->add('Image', FileType::class)
              ->add('date')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('Image')->getData()){
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('Image')->getData();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('evenements_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $evenement->setImage($fileName);
}
            $this->getDoctrine()->getManager()->flush();

              return $this->redirectToRoute('afficher_evenement', array(
                'id' => $evenement->getId()
            ));
        }

        return $this->render('evenement/modifier.html.twig', 
            array(
                'evenement' => $evenement,
            'form' => $form->createView(),
        )
        );
    }

    /**
     * @Route("/{id}", name="supprimer_evenement",methods={"DELETE"})
     */
    public function supprimer(Request $request,$id)
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
      $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
return $this->redirectToRoute('index_evenement');
    }
}
