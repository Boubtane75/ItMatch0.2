<?php

namespace App\DataFixtures;

use App\Entity\Cars;
use App\Entity\Comment;
use App\Entity\Hobby;
use App\Entity\Trajet;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixture extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {

        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1 ; $i <= 10 ; $i++ ) {
            $user = new Utilisateur();
            $user->setUsername($faker->userName)
                ->setupfileat($faker->dateTimeBetween('-3 months'))
                ->setFilename($faker->imageUrl())
                ->setVille($faker->country)
                ->setEmail($faker->email)
                ->setPays($faker->city)
                ->setAdress($faker->address)
                ->setPhone($faker->phoneNumber)
                ->setPassword($this->encoder->encodePassword($user,"Boubtane5700"));

            $manager->persist($user);
            for ($h = 1 ; $h <= 5 ; $h++ ) {
                $hobbie = new Hobby();

                $hobbie->setNomHobby($faker->safeColorName)
                         ->addHobbyUser($user);

                $manager->persist($hobbie);
            }
            for ($j = 1 ; $j <= 5 ; $j++ ) {
                $cars = new Cars();
                $cars->setModel("A3");

                $cars->addUtilisateur($user);

                $manager->persist($cars);
            }

            for ($k = 1 ; $k <= 3 ; $k++ ) {
                $trajet = new Trajet();
                $trajet->setLieuDepart($faker->city)
                        ->setLieuArrived($faker->city)
                        ->setHeureDepart($faker->dateTimeBetween('-2 months'));

                $trajet->setConducteurId($user);

                $manager->persist($trajet);
            }

            for ($q = 1 ; $q <= 2 ; $q++ ) {
                $comente = new Comment();
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
