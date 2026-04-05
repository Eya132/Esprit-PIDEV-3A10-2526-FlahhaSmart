<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AdminUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isNew = $options['is_new'];

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
            ->add('role', ChoiceType::class, [
                'label'   => 'Role',
                'attr'    => ['class' => 'form-select'],
                'choices' => [
                    'Administrateur' => 'ADMINISTRATEUR',
                    'Agriculteur'    => 'AGRICULTEUR',
                    'Client'         => 'CLIENT',
                ],
            ])
            ->add('actif', CheckboxType::class, [
                'label'    => 'Compte actif',
                'required' => false,
                'attr'     => ['class' => 'form-check-input'],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label'    => $isNew ? 'Mot de passe' : 'Nouveau mot de passe (laisser vide pour ne pas changer)',
                'mapped'   => false,
                'required' => $isNew,
                'attr'     => ['class' => 'form-control', 'placeholder' => $isNew ? 'Mot de passe' : 'Laisser vide pour ne pas changer'],
                'constraints' => $isNew ? [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 6]),
                ] : [
                    new Assert\Length(['min' => 6]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'is_new'     => true,
        ]);
    }
}
