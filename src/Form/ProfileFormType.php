<?php
// src/Form/ProfileFormType.php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr'  => ['class' => 'form-control'],
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('prenom', TextType::class, [
                'label'    => 'Prenom',
                'required' => false,
                'attr'     => ['class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr'  => ['class' => 'form-control'],
                'constraints' => [new Assert\NotBlank(), new Assert\Email()],
            ])
            ->add('telephone', TextType::class, [
                'label'    => 'Telephone',
                'required' => false,
                'attr'     => ['class' => 'form-control'],
            ])
            ->add('ville', TextType::class, [
                'label'    => 'Ville',
                'required' => false,
                'attr'     => ['class' => 'form-control'],
            ])
            ->add('newPassword', RepeatedType::class, [
                'type'           => PasswordType::class,
                'mapped'         => false,
                'required'       => false,
                'first_options'  => [
                    'label' => 'Nouveau mot de passe',
                    'attr'  => ['class' => 'form-control', 'placeholder' => 'Laisser vide pour ne pas changer'],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr'  => ['class' => 'form-control', 'placeholder' => 'Repetez le mot de passe'],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}