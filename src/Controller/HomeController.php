<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    * @Route("/presentation-de-l-entreprise", name="home_presentation")
     */
    public function presentation()
    {
        $company = $this->getDoctrine()->getRepository(Company::class)->find(1);
        return $this->render('home/presentation.html.twig', [
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