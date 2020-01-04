<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'Votre prénom :'])
            ->add('lastname', TextType::class, ['label' => 'Votre nom :'])
            ->add('object', TextType::class, ['label' => 'L’objet de votre message :'])
            ->add('email', TextType::class, ['label' => 'Votre adresse email :'])
            ->add('telephone', TextType::class, [
                    'label' => 'Votre numéro de téléphone (facultatif) :',
                    'required' => false,
                ])
            ->add('mobile', TextType::class, [
                    'label' => 'Votre numéro de mobile (facultatif) :',
                    'required' => false,
                ])
            ->add('company', TextType::class, [
                    'label' => 'Votre organisme (facultatif) :',
                    'required' => false,
                ])
            ->add('fonction', TextType::class, [
                    'label' => 'Votre fonction (facultatif) :',
                    'required' => false,
                ])
            ->add('accept', CheckboxType::class, [
                    'label' => 'Je confirme l\'envoi de ce mail',
                    'required' => false,
                ])
            ->add('message', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}