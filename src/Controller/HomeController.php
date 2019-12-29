<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
    * @Route("/", name="home_default") 
    * @Route("/accueil", name="home_index")
     */
    public function index()
    {
        $company = $this->getDoctrine()->getRepository(Company::class)->find(1);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'company' => $company,
        ]);
    }

    /**
    * @Route("/admin", name="home_admin")
     */
    public function admin()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}