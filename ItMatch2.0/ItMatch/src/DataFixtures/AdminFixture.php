<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use App\Entity\Trajet;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixture extends Fixture
{
    /**
     * @var UserInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
  {

      $this->encoder = $encoder;
  }

    public function load(ObjectManager $manager )
    {

        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1 ; $i <= 1 ; $i++ ) {
            $user = new Utilisateur();
            $user->setUsername("momo")
                ->setupfileat($faker->dateTimeBetween('-3 months'))
                ->setFilename($faker->imageUrl())
                ->setVille($faker->country)
                ->setEmail("momo@live.fr")
                ->setPays($faker->city)
                ->setAdress($faker->address)
                ->setPhone($faker->phoneNumber)
                ->setPassword($this->encoder->encodePassword($user, "Boubtane5700"));

            $manager->persist($user);

            for ($p = 1; $p <= 3; $p++) {
                $hobbies = new Hobby();
                $hobbies->setNomHobby($faker->safeColorName);

                $hobbies->addHobbyUser($user);
                $manager->persist($hobbies);
            }
            for ($q = 1; $q <= 10; $q++) {
                $trajet = new Trajet();
                $trajet->setLieuDepart("paris")
                    ->setLieuArrived("rouen")
                    ->setHeureDepart($faker->dateTimeBetween('-2 months'));

                $trajet->setConducteurId($user);
                $manager->persist($trajet);
            }
            for ($q = 1 ; $q <= 2 ; $q++ ) {
                $comente = new \App\Entity\Comment();
                $comente->setContenu($faker->paragraph)
                    ->setCreatedAd($faker->dateTimeBetween('-30 years'))
                    ->setAuthor($faker->name);
                $comente->setTrajet($trajet);

                $manager->persist($comente);
            }

        }
        $manager->flush();
    }
}
