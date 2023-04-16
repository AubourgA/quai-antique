<?php

namespace App\Controller\Admin;

use App\Entity\Entree;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EntreeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Entree::class;
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
        BooleanField::new('isActive', 'Afficher Entree ?'),
        
        ];
    }
    
}
