<?php

namespace App\Controller\Admin;

use App\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GalleryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gallery::class;
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
        if (!$entityInstance instanceof Gallery) return;

        $entityInstance->setSupervisor($this->getUser());

        parent::persistEntity($em, $entityInstance);
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->showEntityActionsInlined();
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            ImageField::new('URLimage', 'URL Image')
            ->setBasePath('/img/slideshow')
            ->setUploadDir('public/img/slideshow')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->setHelp('.jpg or .png only')

        ];
    }
    
}
