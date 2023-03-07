<?php

namespace App\Controller\Admin;


use App\Entity\Menu;
use App\Entity\Meals;
use App\Entity\Entree;
use App\Entity\Booking;
use App\Entity\Dessert;
use App\Entity\Gallery;
use App\Entity\Capacity;
use App\Entity\Schedule;
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
        yield MenuItem::linkToCrud('Les Entrees', 'fa fa-bacon', Entree::class);
        yield MenuItem::linkToCrud('Les Plats', 'fas fa-burger', Meals::class);
        yield MenuItem::linkToCrud('Les Desserts', 'fa-solid fa-ice-cream', Dessert::class);
        yield MenuItem::linkToCrud('Les Menus', 'fa-solid fa-list-ul', Menu::class);
        yield MenuItem::section('Reservations');
        yield MenuItem::linkToCrud('Liste', 'fa-solid fa-utensils', Booking::class);
        yield MenuItem::section('Presentation Plats');
        yield MenuItem::linkToCrud('Carrousel', 'fa-regular fa-image', Gallery::class);
        yield MenuItem::section('Parametres');
        yield MenuItem::linkToCrud('Limit Places Services', 'fa-solid fa-chair', Capacity::class);
        yield MenuItem::linkToCrud('Les Horaires', 'fa-solid fa-clock', Schedule::class);

    }
}
