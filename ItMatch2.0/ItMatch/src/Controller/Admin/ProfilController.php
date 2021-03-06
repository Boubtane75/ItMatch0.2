<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use App\Form\UserTpeType;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\DateTime;


class ProfilController extends AbstractController
{

    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UtilisateurRepository $repository, ObjectManager $em,UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->encoder = $encoder;
    }


    /**
     * @Route("/Admin",name="Admin")
     */

    public function show ()
    {
       $user = $this->repository->findAll();


        return $this->render('Admin/admin.html.twig',[
             'user'=>$user,
            ]
        );
    }

    /**
     * @Route("/Admin/new",name="Admin.new")
     */

    public function new(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new Utilisateur();
        $form = $this->createForm(UserTpeType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())

        {
            $user->setupfileat(new \DateTime());
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success','Profile créé');
            return $this->redirectToRoute('Admin');

        }
        return $this->render('Admin/new.html.twig',[
           'user'=> $user,
           'form' =>$form->createView()
        ]);

    }

    /**
     * @Route("/Admin/{id}",name="Admin.edit" ,methods="POST|GET")
     */
    public function edit (Utilisateur $user,Request $request)
    {
        $form = $this->createForm(UserTpeType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isSubmitted())
        {

            $hash = $this->encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $this->em->flush();
            $this->addFlash('success','Profile modifié');
            return $this->redirectToRoute('Admin');

        }
        return $this->render('Admin/edit.html.twig',[
            'user' =>$user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/Admin/{id}",name="Admin.delete", methods="DELETE")
     */
    public function delete (Utilisateur $user)
    {

        $this->em->remove($user);
        $this->em->flush();
        $this->addFlash('success','Profile suprimer');

        return $this->redirectToRoute('Admin');
    }

}
