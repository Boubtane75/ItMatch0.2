<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Passager;
use App\Entity\Trajet;
use App\Entity\trajetSearch;
use App\Entity\Utilisateur;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Form\TrajetSearchType;
use App\Form\TrajetType;
use App\Form\UserTpeType;
use App\Notification\ContactNotif;
use App\Repository\TrajetRepository;
use App\Service\formSearch;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\This;
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
    public function index(Request $request, PaginatorInterface $page ,TrajetRepository $repository)
    {
        $search = new trajetSearch();
        $form = $this->createForm(TrajetSearchType::class,$search);
        $form->handleRequest($request);
        $critaire = array('LieuDepart'=>$search->getDepart(),'LieuArrived'=>$search->getArriver());
        $trajet = $page->paginate(
            $repository->findByExampleField($critaire),
            $request->query->getInt('page',1),
            3
        );

        return $this->render('home/index.html.twig',[
            'form' => $form->createView(),
            'trajet' =>$trajet,
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

    public function profile (Utilisateur $user,Request $request,ObjectManager $em)
    {
        $form = $this->createForm(UserTpeType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isSubmitted())
        {
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
           return $this->redirectToRoute('home');

          // return $this->redirectToRoute('voir');
       }

        return $this->render('home/trajet.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/test{id}",name="test")
     */

    public function teste (Trajet $trajects,$id, Request $request, ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Trajet::class);
        $repi = $this->getDoctrine()->getRepository(Comment::class);
        $comments = $repi->findAll();
        $trajet = $repo->find($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {
            $comment->setCreatedAd(new \DateTime())
                    ->setTrajet($trajet);
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('test',['id'=>$trajects->getId()]);
        }

        return $this->render('home/test.html.twig',[
            'coment'=>$comments,
            'form' => $form->createView(),
            'trajet'=>$trajet
        ]);

    }


    /**
     * @Route("/tchat",name="tchat")
     */

    public function tchat ()
    {
        return $this->render('home/tchat.html.twig');
    }


}
