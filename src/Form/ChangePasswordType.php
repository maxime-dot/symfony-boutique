<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'disabled' => true,
                'label' => 'Adresse Mail'
            ])
            ->add('firstname', TextType::class,[
                'disabled' => true,
                'label' => 'Votre Nom'
            ])
            ->add('lastname', TextType::class,[
                'disabled' => true,
                'label' => 'Votre prénom'
            ])
            ->add('old_password', PasswordType::class,[
                'label' => 'Votre mot de passe actuel',
                'mapped' => false,
                'attr' =>[
                    'placeholder' => 'Tapez votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent etre identique',
                'required' => true,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'votre nouveau mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre  nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Retapez votre nouveau mot de passe'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => "Mettre à jour"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
