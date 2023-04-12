<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'Le champ Email doit correspondre',
                'required' => true,
                'first_options' => ['label' => 'Email', 'attr'=> ['class' => 'form-control']],
                'second_options' => ['label' => 'Répéter votre Email', 'attr'=> ['class' => 'form-control']],
                'attr' => ['class' => 'form-control']
            ])
            ->add('plainpassword', PasswordType::class, [
                'attr' => ['class' => 'form-control' ],
                'label' =>'Mot de Passe'
            ])
            ->add('Allergy', TextType::class, [
                'attr' => ['class' => 'form-control' ],
                'label' => 'Allergies',
                'required' => false
            ])
            ->add('DefaultPerson', NumberType::class , [
                'attr' => ['class' => 'form-control' ],
                'label' => 'Nombre de personnes par défaut'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'form__btn btn__connect text--regular' ],
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
