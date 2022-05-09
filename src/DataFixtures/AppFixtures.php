<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Message;
use App\Entity\Property;
use App\Entity\ContactAIK;
use App\Entity\Testimanial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
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
        //property fixtures
        $properties = [];
        $faker = Factory::create('FR-fr');
        for ( $i = 0 ; $i < 100; $i++){
            $property = new Property();
            $property
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3,true))
                ->setSpace($faker->numberBetween(20,350))
                ->setRooms($faker->numberBetween(2,15))
                ->setBathrooms($faker->numberBetween(2,10))
                ->setBedrooms($faker->numberBetween(2,10))
                ->setParking($faker->numberBetween(0,6))
                ->setFloors($faker->numberBetween(1,5))
                ->setPrice($faker->numberBetween(80000,2000000))
                ->setSituation($faker->numberBetween(0, count(Property::SITUATION) - 1))
                ->setState($faker->numberBetween(0, count(Property::STATES) - 1))
                ->setType($faker->numberBetween(0, count(Property::TYPE) - 1))
                ->setCooling($faker->words(1, true))
                ->setHeating($faker->words(1, true))
                ->setAddress($faker->address)
                ->setCity($faker->city)
                ->setLng($faker->numberBetween(0,100))
                ->setLat($faker->numberBetween(0,100));

            $manager->persist($property);
            $properties[] = $property;
        }



           //user fixture
           $clients = [];
           for ( $i = 0 ; $i < 20; $i++){   
            $client = new User();

            $property = $properties[mt_rand(0, count($properties) - 1)];

            $client->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setPhone($faker->numberBetween(20000000,99999999))
                ->setDescription($faker->sentence(3,true))
                ->setRole('ROLE_ADMIN');

                for ($j = 0 ; $j < mt_rand( 0, 5) ; $j++){
                    $favory = $properties[mt_rand(0 , count($properties) - 1)];
                    $client->addFavory($favory);
                };

            $hash = $this->encoder->encodePassword($client, 'admin');
            $client->setHash($hash);

            $manager->persist($client);

            

            $clients[] = $client;}

        //message fixture
        for ( $i = 0 ; $i < 30; $i++){   
            $message = new Message();
            $destination = $clients[mt_rand(0 , (count($clients)/2) - 1)];
            $author = $clients[mt_rand((count($clients)/2) , count($clients) - 1)];
            $message->setTitle($faker->words(3, true))
                ->setContent($faker->sentence(3, true))
                ->setDestination($destination)
                ->setAuthor($author);
            $manager->persist($message);
        }

        //testimanial fixture
        for ( $i = 0 ; $i < 10; $i++){   
            $testimanial = new Testimanial();
            $author = $clients[mt_rand(0 , count($clients) - 1)];
            $testimanial->setContent($faker->sentence(3, true))
                ->setAuthor($author);
            $manager->persist($testimanial);
        }

        //contactAIK fixture
        $contactAIK = new ContactAIK();
        $contactAIK
            ->setEmail($faker->email)
            ->setPhone($faker->numberBetween(20000000,99999999))
            ->setGeneralDescri($faker->sentence(3,true))
            ->setSellDescri($faker->sentence(3,true))
            ->setGestionDescri($faker->sentence(3,true))
            ->setContratDescri($faker->sentence(3,true))
            ->setConsultDescri($faker->sentence(3,true))
            ->setAddress($faker->address)
            ->setLng($faker->numberBetween(0,100))
            ->setLat($faker->numberBetween(0,100))
            ->setFacebook($faker->email)
            ->setInstagram($faker->email)
            ->setLinkedin($faker->email)
            ->setTwitter($faker->email);
            $manager->persist($contactAIK);

        $manager->flush();
    }
    
}