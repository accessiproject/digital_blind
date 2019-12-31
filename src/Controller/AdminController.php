<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
    * @Route("/profil", name="admin_profil_index") 
     */
    public function profil_index()
    {
        $company = $this->getDoctrine()->getRepository(Company::class)->find(1);
        return $this->render('admin/profil/index.html.twig', [
            'controller_name' => 'AdminController',
            'company' => $company,
        ]);
    }

    /**
     * @Route("/profil/edition", name="admin_profil_edit")
     */
    public function profil_edit(Request $request, EntityManagerInterface $manager)
    {
        $company = $manager->getRepository(Company::class)->find(1);
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($company);
            $manager->flush();
            return $this->redirectToRoute('admin_profil_index');
        }
        return $this->render('admin/profil/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}