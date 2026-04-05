<?php
// src/Form/RegistrationFormType.php
namespace App\Form;

use App\Entity\Users;  // Changé de User à Users
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr'  => ['placeholder' => 'Votre nom'],
                'constraints' => [new Assert\NotBlank(), new Assert\Length(['min' => 2, 'max' => 100])],
            ])
            ->add('prenom', TextType::class, [
                'label'    => 'Prénom',
                'required' => false,
                'attr'     => ['placeholder' => 'Votre prénom'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr'  => ['placeholder' => 'email@exemple.com'],
                'constraints' => [new Assert\NotBlank(), new Assert\Email()],
            ])
            ->add('telephone', TextType::class, [
                'label'    => 'Téléphone',
                'required' => false,
                'attr'     => ['placeholder' => '+216 XX XXX XXX'],
            ])
            ->add('ville', TextType::class, [
                'label'    => 'Ville',
                'required' => false,
                'attr'     => ['placeholder' => 'Tunis'],
            ])
            ->add('role', ChoiceType::class, [
                'label'   => 'Type de compte',
                'choices' => [
                    'Agriculteur' => 'AGRICULTEUR',
                    'Client'      => 'CLIENT',
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'            => PasswordType::class,
                'mapped'          => false,
                'first_options'   => ['label' => 'Mot de passe', 'attr' => ['placeholder' => '••••••••']],
                'second_options'  => ['label' => 'Confirmer le mot de passe', 'attr' => ['placeholder' => '••••••••']],
                'constraints'     => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 6]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,  // Changé de User::class à Users::class
        ]);
    }
}