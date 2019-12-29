<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppCompany extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $company = new Company();
        $company->setName("Digital Blind")
            ->setLogo("image\logo")
            ->setSummary("Résumé")
            ->setPresentation("Présentation")
            ->setAddress("39 avenue Georges Bernanos")
            ->setPostalcode("75005")
            ->setCity("Paris")
            ->setPhone("0254822623")
            ->setMobile("0630300904");
        $manager->persist($company);

        $manager->flush();
    }
}
