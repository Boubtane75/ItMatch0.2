<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Utilisateur;
use App\Form\ContactType;
use App\Notification\ContactNotif;
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
     * @Route ("",name="base")
     */

    public function base(Utilisateur $user)
    {



        return $this->render('base.html.twig',[
            'user'=> $user
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
            $this->addFlash('sucess','votre email a bien été envoyé');
            /*
            return $this->redirectToRoute('contact');
            */
        }
        return $this->render('home/Contact.html.twig',[
           'form' => $form->createView()
        ]);


    }
}
