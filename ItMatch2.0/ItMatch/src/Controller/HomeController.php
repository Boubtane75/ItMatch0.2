<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Trajet;
use App\Entity\Utilisateur;
use App\Form\ContactType;
use App\Form\TrajetType;
use App\Form\UserTpeType;
use App\Notification\ContactNotif;
use App\Repository\CarsRepository;
use App\Repository\TrajetRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Datetime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController

{

    /**
     * @Route("/", name="home")
     */
    public function index(TrajetRepository $repository)
    {
        $trajet = $repository->findAll();

        return $this->render('home/index.html.twig',[
            'trajet' =>$trajet
        ]);
    }

      /**
     * @Route("/search", name="search")
     */
    public function search()
    {
        $date = new DateTime();
        return $this->render('home/search.html.twig', [
            'today' => $date->format('d/m/Y')
        ]);
    }

    /**
     * @Route("/Contact", name="contact")
     */
    public function Contact(Request $request,ContactNotif $notif):Response
    {
        $contact = new Contact();


        $form = $this->createForm(ContactType::class,$contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {

            $notif->notify($contact);
            $this->addFlash('success','votre email a bien été envoyé');
            return $this->redirectToRoute('contact');

        }
        return $this->render('home/Contact.html.twig',[
           'form' => $form->createView()
        ]);


    }
    /**
     * @Route("/profile/{id}", name="profile", methods="POST|GET")
     */

    public function profile (Utilisateur $user,Request $request,ObjectManager $em,UserPasswordEncoderInterface $encoder)
    {

        $form = $this->createForm(UserTpeType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isSubmitted())
        {

            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $em->flush();
            $this->addFlash('success','Profile modifié');
            return $this->redirectToRoute('home');

        }
        return $this->render('home/Profile.html.twig',[
            'user' =>$user,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/trajet",name="trajet")
     */

    public function CreateTrajet(Request $request,ObjectManager $manager)
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class,$trajet);
        $form->handleRequest($request);


       if ($form->isSubmitted() && $form->isValid())
       {
           $trajet->setConducteurId($this->getUser());
           $manager->persist($trajet);
           $manager->flush();

          // return $this->redirectToRoute('voir');
       }

        return $this->render('home/trajet.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/all",name="all")
     */

    public function showTrajet (TrajetRepository $repository)
    {

        $trajet = $repository->findAll();

        return $this->render('home/voirTrajet.html.twig',[
                'trajet'=>$trajet,
            ]
        );
    }


}
