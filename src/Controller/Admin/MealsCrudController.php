<?php

namespace App\Controller\Admin;

use App\Entity\Meals;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MealsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Meals::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->showEntityActionsInlined();
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
             IdField::new('id', '#')->hideOnForm(),
        TextField::new('Title', 'Titre'),
        TextField::new('Description'),
        NumberField::new('Price', 'Prix €'),
        DateTimeField::new('createdAt')
            ->hideOnForm(),       
        BooleanField::new('isActive', 'Afficher Plats ?'),
        ];
    }
    
}
