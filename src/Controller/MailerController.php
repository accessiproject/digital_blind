<?php

namespace App\Controller;

use Swift_Mailer;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\EditType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MailerController extends AbstractController
{

    /**
     * @Route("/contact", name="contact_index")
     */
    public function contact(Request $request, \Swift_Mailer $mailer, EntityManagerInterface $manager)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $company = $form['company']->getData() ? '<li>Organisme : ' . $form['company']->getData() . '</li>' : "";
            $fonction = $form['fonction']->getData() ? '<li>Fonction : ' . $form['fonction']->getData() . '</li>' : "";
            $telephone = $form['telephone']->getData() ? '<li>N° téléphone : <a href="tel:' . $form['telephone']->getData() . '">' . $form['telephone']->getData() . '</a></li>' : "";
            $mobile = $form['mobile']->getData() ? '<li>N° mobile : <a href="' . $form['mobile']->getData() . '">' . $form['mobile']->getData() .  '</a></li>' : "";

            $message = (new \Swift_Message($form['object']->getData()))
                ->setFrom($form['email']->getData())
                ->setTo('kevin.bustamante@mail.novancia.fr')
                ->setBody('
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Mon premier mail</title>
                    </head>
                    <body>
                        <h1>Alerte! Un message vous a été envoyé</h1>
                        <p>Envoyé le ' . date("d/m/Y") . ' à ' . date("H:i:s") .
                    '</p><h2>Informations sur le contact :</h2>
                        <ul>
                            <li>Prénom : ' . $form["firstname"]->getData() . '</li>
                            <li>Nom : ' . $form["lastname"]->getData() . '</li>' . $company . $fonction . '<li>Adresse email : <a href="mailto:' . $form["email"]->getData() . '">' . $form['email']->getData() . '</a></li>' . $telephone . $mobile .
                    '</ul>
                            <h2>Voici le message :</h2>
                            <p>' . $form["message"]->getData() . '</p>

                </body>
                </html>
                ', 'text/html');
            $mailer->send($message);

            $contact->setCreatedat(new \DateTime('now'));
            $contact->setStatut("Initialisé");
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash('success', 'Le message a bien été envoyé !');
            return $this->redirectToRoute('home_default');
        }
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'MailerController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/demande_de_modification/{page}", name="contact_edit")
     */
    public function edit($page, Request $request, \Swift_Mailer $mailer, EntityManagerInterface $manager)
    {

        $tab = array();
        $tab[] = array("url" => "presentation", "libelle" => "01. Présentation et objectiifs du Mooc", "route" => "home_presentation");
        $tab[] = array("url" => "chiffres", "libelle" => "02. Quelques données chiffrées", "route" => "home_chiffres");
        $tab[] = array("url" => "notions", "libelle" => "03. Quelques notions clés à connaître", "route" => "home_notions");
        $tab[] = array("url" => "rendre-accessible-la-telephonie-pour-les-personnes-sourdes-ou-malentendantes", "libelle" => "04. Focus: rendre accessible la telephonie pour les personnes sourdes ou malentendantes", "route" => "home_focus");
        $tab[] = array("url" => "bref-rappel-du-cadre-juridique", "libelle" => "05. Bref rappel du cadre juridique", "route" => "home_juridique");
        $tab[] = array("url" => "solutions-techniques-proposees", "libelle" => "06. Solutions techniques proposées", "route" => "home_solutions");
        $tab[] = array("url" => "de-nouveaux-defis-a-relever", "libelle" => "07. De nouveaux défis à relever", "route" => "home_contraintes");
        $tab[] = array("url" => "conseils-et-preconisations", "libelle" => "08. Conseils et préconisations", "route" => "home_preconisations");
        $tab[] = array("url" => "innovations", "libelle" => "09. Innovations", "route" => "home_innovations");

        for ($i = 0; $i < count($tab); $i++) {
            if ($tab[$i]["url"] == $page) {
                $url = $tab[$i]["url"];
                $libelle = $tab[$i]["libelle"];
                $route = $tab[$i]["route"];
            }
        }

        $contact = new Contact();
        $form = $this->createForm(EditType::class, $contact);
        $form['page']->setData($libelle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $company = $form['company']->getData() ? '<li>Organisme : ' . $form['company']->getData() . '</li>' : "";
            $fonction = $form['fonction']->getData() ? '<li>Fonction : ' . $form['fonction']->getData() . '</li>' : "";
            $telephone = $form['telephone']->getData() ? '<li>N° téléphone : <a href="tel:' . $form['telephone']->getData() . '">' . $form['telephone']->getData() . '</a></li>' : "";
            $mobile = $form['mobile']->getData() ? '<li>N° mobile : <a href="' . $form['mobile']->getData() . '">' . $form['mobile']->getData() .  '</a></li>' : "";

            $message = (new \Swift_Message($form['object']->getData()))
                ->setFrom($form['email']->getData())
                ->setTo('kevin.bustamante@mail.novancia.fr')
                ->setBody('
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Mon premier mail</title>
                    </head>
                    <body>
                        <h1>Alerte! Un message vous a été envoyé</h1>
                        <p>Envoyé le ' . date("d/m/Y") . ' à ' . date("H:i:s") .
                    '</p><h2>Informations sur le contact :</h2>
                        <ul>
                            <li>Prénom : ' . $form["firstname"]->getData() . '</li>
                            <li>Nom : ' . $form["lastname"]->getData() . '</li>' . $company . $fonction . '<li>Adresse email : <a href="mailto:' . $form["email"]->getData() . '">' . $form['email']->getData() . '</a></li>' . $telephone . $mobile .
                    '</ul>
                    <p>Objet : ' . $form['object']->getData() . '</p>
                    <p>Page concernée par le message : ' . $form['page']->getData() . '</p>
                            <h2>Voici le message :</h2>
                            <p>' . $form["message"]->getData() . '</p>

                </body>
                </html>
                ', 'text/html');
            $mailer->send($message);

            $contact->setCreatedat(new \DateTime('now'));
            $contact->setStatut("Initialisé");
            $manager->persist($contact);
            $manager->flush();
            return $this->redirectToRoute($route);
        }
        return $this->render('home/modification.html.twig', [
            'controller_name' => 'MailerController',
            'form' => $form->createView(),
            'page' => $contact->getPage()
        ]);
    }
}
