<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Contact;
use App\Entity\User;
use App\Form\CompanyType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin_account_index", name="admin_account_index") 
     */
    public function account_index()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
        return $this->render('admin/account/index.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin_account_edition", name="admin_account_edit")
     */
    public function account_edit(Request $request, EntityManagerInterface $manager)
    {
        $user = $manager->getRepository(User::class)->find($this->getUser());
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('admin_account_index');
        }
        return $this->render('admin/account/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin_profil_index", name="admin_profil_index") 
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
     * @Route("/admin_profil_edition", name="admin_profil_edit")
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

    /**
     * @Route("/admin_notification_index", name="admin_notification_index") 
     */
    public function notification_index()
    {
        $notifications = $this->getDoctrine()->getRepository(Contact::class)->findContactStatut("Initialisé","DESC");
        return $this->render('admin/notification/index.html.twig', [
            'controller_name' => 'AdminController',
            'notifications' => $notifications,
        ]);
    }
}
