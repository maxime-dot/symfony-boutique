<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => 'Nom',
                'constraints' => new Length([
                    'min' => 3 ,
                    'max' => 30
                ]),
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre nom...'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre Prénom...'
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre email...'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent etre identique',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
            ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    ] ,
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Tapez votre mot de passe'
                ]
            ])
            
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
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
