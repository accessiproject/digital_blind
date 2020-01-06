<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TestController extends AbstractController
{

    /**
     * @Route("/test", name="test_index")
     */
    public function contact(Request $request, Mailer $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bodyMail = $mailer->createBodyMail('test/mail.html.twig');
            $mailer->sendMessage('kevin.bustamante@mail.novancia.fr', 'kevin.bustamante@mail.novancia.fr', 'renouvellement du mot de passe', $bodyMail);
            return $this->redirectToRoute('home_default');
        }
        return $this->render('test/contact.html.twig', [
            'controller_name' => 'TestController',
            'form' => $form->createView(),
        ]);
    }
}
