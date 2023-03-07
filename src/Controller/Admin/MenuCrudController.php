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
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

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

          
            FormField::addPanel('Menu Info :'),
            TextField::new('Title'),
            TextField::new('Price'),

            ImageField::new('url_image')
            ->setUploadDir('public/img/menus')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->hideOnIndex()
            ->setHelp('.jpg or .png only'),
            FormField::addPanel('Menu Composition :'),
            DateTimeField::new('createdAt')
                ->hideOnForm(),

             
            AssociationField::new('entree')
                    ->setFormTypeOptions( [
                        'multiple'=> true,
                        'by_reference' => false
                    ]),
                   
            AssociationField::new('meals')
            ->setFormTypeOptions( [
                'multiple'=> true,
                'by_reference' => false
            ]),
            AssociationField::new('dessert')
            ->setFormTypeOptions( [
                'multiple'=> true,
                'by_reference' => false
            ]),
            BooleanField::new('isActive', 'Afficher le Menu ?'),
            
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->showEntityActionsInlined();
    }
    
}
