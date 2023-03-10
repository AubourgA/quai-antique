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
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        
        //graph
        $dataLunch = [65,59,80,81,55,40];
        $dataDinner = [30,25,25,25,25,25];
        $dataDate = ['30/2/2023','29/2/2023','28/02/2023','27/02/2023','26/02/2023','27/2023'];

         return $this->render('admin/dashboard.html.twig', [
            'dataLunch' => json_encode($dataLunch),
            'dataDinner' =>json_encode($dataDinner),
            'dataDate' => json_encode($dataDate)
         ]
         );
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

    /**
     * Add css file for admin dashboard
     *
     * @return Assets
     */
    public function configureAssets(): Assets
    {
        return Assets::new()
                    ->addCssFile('css/admin.css');
                    // ->addJsFile('js/admin.js');
                 
    }
}
