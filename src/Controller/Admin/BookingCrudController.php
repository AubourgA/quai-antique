<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);   
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->showEntityActionsInlined();
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('CreatedAt', 'Généré le')
                    ->setFormat('dd/MM/yyyy à HH:mm'),
            DateField::new('date','Jour')
                    ->setFormat('dd/MM/yyyy'),
            DateField::new('time', 'Heure')
                    ->setFormat('HH:mm'),
            NumberField::new('NumberPerson', 'Nombre Couverts'),
            TextField::new('Customer.firstname', 'Prenom')
                    ->onlyOnDetail(),
            TextField::new('Customer.lastname', 'Nom'),
            TextField::new('Customer.allergy', 'Allergies')
                    ->onlyOnDetail(),
            EmailField::new('Customer.email', 'Email')
                    ->onlyOnDetail()
        ];
    }
    
}
