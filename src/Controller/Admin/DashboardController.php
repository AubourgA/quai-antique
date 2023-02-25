<?php

namespace App\Controller\Admin;


use App\Entity\Menu;
use App\Entity\Meals;
use App\Entity\Entree;
use App\Entity\Dessert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        
        
        //
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LeQuaiAntique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Restauration');
        yield MenuItem::linkToCrud('Entrees', 'fa fa-bacon', Entree::class);
        yield MenuItem::linkToCrud('Plats', 'fas fa-burger', Meals::class);
        yield MenuItem::linkToCrud('Desserts', 'fa-solid fa-ice-cream', Dessert::class);
        yield MenuItem::linkToCrud('Menu', 'fa-solid fa-list-ul', Menu::class);

        yield MenuItem::section('Reservation');
        yield MenuItem::section('Gestion HomePage');

    }
}
