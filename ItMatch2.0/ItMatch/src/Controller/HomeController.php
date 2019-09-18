<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Utilisateur;
use App\Form\ContactType;
use App\Form\UserTpeType;
use App\Notification\ContactNotif;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController

{



    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        return $this->render('home/index.html.twig',[

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
     * @Route("/profile", name="profile")
     */

    public function profile (Request $request)
    {
        $form = $this->createForm(UserTpeType::class);
        $form->handleRequest($request);

        return $this->render('home/Profile.html.twig',[
            'form' => $form->createView()
        ]);
    }

}
