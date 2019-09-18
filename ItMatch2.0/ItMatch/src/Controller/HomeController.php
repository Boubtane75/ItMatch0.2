<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Datetime;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
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
}
