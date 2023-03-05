<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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

      /**
     * set the user_id to put in database
     *
     * @param EntityManagerInterface $em
     * @param [type] $entityInstance
     * @return void
     */
    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Menu) return;

        $entityInstance->setAdmin($this->getUser());

        parent::persistEntity($em, $entityInstance);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Title'),
            TextField::new('Price'),


            ImageField::new('url_image')
                    ->setUploadDir('public/img/menus')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->hideOnIndex()
                    ->setHelp('.jpg or .png only'),
            DateTimeField::new('createdAt')
                ->hideOnForm(),
            AssociationField::new('entree')
                    ->setFormTypeOptions( [
                        'multiple'=> true,
                        'by_reference' => false
                        ])
                    ->hideOnIndex(),
            AssociationField::new('meals')
            ->setFormTypeOptions( [
                'multiple'=> true,
                'by_reference' => false
                ])
            ->hideOnIndex(),
            AssociationField::new('dessert')
            ->setFormTypeOptions( [
                'multiple'=> true,
                'by_reference' => false
                ])
            ->hideOnIndex(),
            BooleanField::new('isActive', 'Afficher le Menu ?'),
            
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->showEntityActionsInlined();
    }
    
}
