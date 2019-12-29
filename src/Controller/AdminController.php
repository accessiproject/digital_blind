<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
    * @Route("/", name="admin_profil_index") 
     */
    public function profil_index()
    {
        $company = $this->getDoctrine()->getRepository(Company::class)->find(1);
        return $this->render('admin/profil/index.html.twig', [
            'controller_name' => 'AdminController',
            'company' => $company,
        ]);
    }
}