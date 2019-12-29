<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
    * @Route("/", name="home_default") 
    * @Route("/accueil", name="home_index")
     */
    public function index()
    {
        $company = $this->getDoctrine()->getRepository(Company::class)->find(1);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'AdminController',
            'company' => $company,
        ]);
    }
}