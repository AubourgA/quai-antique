<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscribeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Firstname', TextType::class, [
                'attr' => ['class' => 'form-control' ],
                'label' => 'Prenom'
            ])
            ->add('Lastname', TextType::class, [
                'attr' => ['class' => 'form-control' ],
                'label' => 'Nom'
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control' ]
            ])
            ->add('plainpassword', PasswordType::class, [
                'attr' => ['class' => 'form-control' ],
                'label' =>'Mot de Passe'
            ])
            ->add('Allergy', TextType::class, [
                'attr' => ['class' => 'form-control' ]
            ])
            ->add('DefaultPerson', NumberType::class , [
                'attr' => ['class' => 'form-control' ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'form__btn btn__connect item__text--regular' ],
                'label' => 'S\'inscrire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
