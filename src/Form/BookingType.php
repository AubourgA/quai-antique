<?php

namespace App\Form;


use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
     
            ->add('Date', DateType::class, [
                'widget'=>'single_text',
                'attr' => [
                    'readonly' => true,
                    'class' => 'text--regular'
                ]
            ])
            ->add('time', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'readonly' => true,
                    'class' => 'text--regular'
                ],
                'label_attr' => [
                    'class' => 'text--regular'
                ]
            ])
            ->add('numberPerson', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'class' => 'text--regular'
                ],
                'constraints' => [
                    new Assert\Range([
                        'min' => 1,
                        'max' => 10,
                    ])
                ]
            ])
            ->add('Allergy', TextType::class, [
                'attr' => ['class' => 'text--regular' ],
                'required' => false,
                'constraints' => [
                    new Assert\Regex('/^[a-zA-Z ]+$/')
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
