<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppCompany extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // initialisation de l'objet Faker
        // on peut préciser en paramètre la localisation, 
        // pour avoir des données qui semblent "françaises"
        $faker = Faker\Factory::create('fr_FR');
        
        $company = new Company();
        $company->setName("Digital Blind")
            ->setLogo("image\logo")
            ->setSummary("Voici le résumé !")
            ->setPresentation("Voici la présentation")
            ->setAddress($faker->address)
            ->setPostalcode($faker->postcode)
            ->setCity($faker->city)
            ->setPhone("0254822623")
            ->setMobile("0630300904");
        $manager->persist($company);

        $manager->flush();
    }
}
