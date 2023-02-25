<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Title'),
            TextField::new('Price'),
            ImageField::new('url_image')
                    ->setBasePath('public/img')
                    ->setUploadDir('public/img/plats')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->hideOnIndex(),
            DateTimeField::new('createdAt')
                ->hideOnForm(),
            AssociationField::new('entree'),
            BooleanField::new('isActive', 'Afficher le Menu ?'),
        ];
    }
    
}
