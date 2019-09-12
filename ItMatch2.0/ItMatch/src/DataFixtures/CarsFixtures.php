<?php

namespace App\DataFixtures;

use App\Entity\Cars;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CarsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       for ($i = 1;$i<=120; $i++)
       {
           $cars = new Cars();
           $cars->setMarque()
               ->setModel();

           $manager->persist($cars);
       }

        $manager->flush();
    }
}
