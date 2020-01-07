<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use App\Service\Mailer;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MailerController extends AbstractController
{

    /**
     * @Route("/contact", name="contact_index")
     */
    public function contact(Request $request, Mailer $mailer, EntityManagerInterface $manager)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setCreatedat(new \DateTime('now'));
            $contact->setStatut("Initialisé");
            $manager->persist($contact);
            $manager->flush();
            $user = $manager->getRepository(User::class)->findAll();
            foreach ($user as $from) {
                $bodyMail = $mailer->createBodyMail('home/mail.html.twig', [
                    'contact' => $contact
                ]);
                $mailer->sendMessage($contact->getEmail(), $from->getEmail(), $contact->getObject(), $bodyMail);
            }
            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('home_default');
        }
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'MailerController',
            'form' => $form->createView(),
        ]);
    }
}
