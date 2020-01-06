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
            $company = $form['company']->getData() ? '<li>Organisme : ' . $form['company']->getData() . '</li>' : "";
            $fonction = $form['fonction']->getData() ? '<li>Fonction : ' . $form['fonction']->getData() . '</li>' : "";
            $telephone = $form['telephone']->getData() ? '<li>N° téléphone : <a href="tel:' . $form['telephone']->getData() . '">' . $form['telephone']->getData() . '</a></li>' : "";
            $mobile = $form['mobile']->getData() ? '<li>N° mobile : <a href="' . $form['mobile']->getData() . '">' . $form['mobile']->getData() .  '</a></li>' : "";
            $contact->setCreatedat(new \DateTime('now'));
            $contact->setStatut("Initialisé");
            $manager->persist($contact);
            $manager->flush();
            $user = $manager->getRepository(User::class)->findAll();
            foreach ($user as $valeur) {
                $bodyMail = $mailer->createBodyMail('home/mail.html.twig', [
                    'contact' => $contact
                ]);
                $mailer->sendMessage($contact->getEmail(), $this->getEmail(), $contact->getObject(), $bodyMail);
                $this->addFlash('success', 'Votre message a bien été envoyé !');
                return $this->redirectToRoute('home_default');
        }
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'MailerController',
            'form' => $form->createView(),
        ]);
    }
}
