<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Quel est nom souhaitez-vous  donner à votre adresse',
                'attr' =>[
                    'placeholder' => 'Nommez votre adresse'
                ]
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Quel est votre nom',
                'attr' =>[
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Quel est votre Prénom',
                'attr' =>[
                    'placeholder' => 'votre prénom'
                ]
            ])
            ->add('company', TextType::class,[
                'label' => 'Quel est votre nom de votre Entreprise',
                'attr' =>[
                    'placeholder' => 'Le nom de votre Entreprise'
                ]
            ])
            ->add('addresse', TextType::class,[
                'label' => 'Votre Adresse',
                'attr' =>[
                    'placeholder' => '8 Rue de Ralaimongo'
                ]
            ])
            ->add('postal', TextType::class,[
                'label' => 'Code Postal',
                'attr' =>[
                    'placeholder' => '101 Antananarivo'
                ]
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville',
                'attr' =>[
                    'placeholder' => 'Fianarantsoa'
                ]
            ])
            ->add('country', CountryType::class,[
                'label' => 'Pays',
                'attr' =>[
                    'placeholder' => 'France'
                ]
            ])
            ->add('phone', TelType::class,[
                'label' => 'Télèphone',
                'attr' =>[
                    'placeholder' => '+0347199820'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Ajouter une adresse',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
