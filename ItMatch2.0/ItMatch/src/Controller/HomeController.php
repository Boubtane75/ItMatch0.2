<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Hobby;
use App\Entity\Trajet;
use App\Entity\trajetSearch;
use App\Entity\Utilisateur;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Form\HobbyType;
use App\Form\TrajetSearchType;
use App\Form\TrajetType;
use App\Form\UserTpeType;
use App\Notification\ContactNotif;
use App\Repository\HobbyRepository;
use App\Repository\TrajetRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Datetime;

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
     * @Route("/Trajet/{id}",name="Trajet")
     */

    public function letrajet ($id, Trajet $trajects, Request $request, ObjectManager $manager)
    {
        $hobieConducteur = $trajects->getConducteurId()->getHobbies()->getValues();
        $passagers = $trajects->getPassager()->getValues();

        $listpassagerHobbie = [];
        foreach ($passagers as $passager)
        {
            $tabHobies = [];
            $hohbiespassager = $passager->getHobbies()->getValues();

            foreach ($hohbiespassager as $hobiespassager)
            {
                foreach ($hobieConducteur as $hobiesconduteur)
                {
                    if ($hobiespassager == $hobiesconduteur){
                        $hobbiefinal = $hobiespassager;
                        array_push($tabHobies,$hobbiefinal);
                    }
                }
            }

            array_push($listpassagerHobbie, $tabHobies);
           // dd($tabHobies);
            //return $tabHobies;
        }


        $idTrajet = $trajects->getId();
        $user = $this->getUser();
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
            dd($comment);
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('Trajet',['id' => $idTrajet]);
        }

        return $this->render('home/TrajetUtilisateur.html.twig',[
            'hobbies' =>$listpassagerHobbie,
            'user' => $user,
            'coment'=>$comments,
            'form' => $form->createView(),
            'trajet'=>$trajet
        ]);

    }


    /**
     * @Route("/Rejoindre/{id}",name="Rejoindre")
     */

    public function rejoindreTrajet($id,ObjectManager $manager, TrajetRepository $repo)
    {

            $trajet = $repo->find($id) ;
            $trajet->addPassager($this->getUser());
            $manager->persist($trajet);
            $manager->flush();
            return $this->redirectToRoute('Trajet',['id' => $id]);


    }


}
