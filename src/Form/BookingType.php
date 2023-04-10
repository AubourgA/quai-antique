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

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
     
            ->add('Date', DateType::class, [
                'widget'=>'single_text',
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('time', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('numberPerson', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 10
                ]
            ])
            ->add('Allergy', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
