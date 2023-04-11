<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Allergy', TextType::class, [
                'attr' => ['class' => 'form__group' ],
                'label' => 'Allergies',
                'required' => false,
                'constraints' => [
                    new Assert\Regex('/^[a-zA-Z ]+$/')
                ]
            ])
            ->add('DefaultPerson', NumberType::class , [
                'attr' => ['class' => 'form__group' ],
                'label' => 'Personnes par défault',
                'constraints' => [
                    new Assert\Range([
                        'min' => 1,
                        'max' => 10,
                    ])
                ]
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

