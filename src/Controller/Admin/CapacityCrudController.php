<?php

namespace App\Controller\Admin;

use App\Entity\Capacity;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CapacityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Capacity::class;
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
        if (!$entityInstance instanceof Capacity) return;

        $entityInstance->setSupervisor($this->getUser());

        parent::persistEntity($em, $entityInstance);
    }
    
    /**
     * Define style action
     *
     * @param Crud $crud
     * @return Crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->showEntityActionsInlined();
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
