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
use App\Repository\BookingRepository;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
      $this->bookingRepository = $bookingRepository;
    }


    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        
        //Get all value needed out of booking 
        $countTodayLunch = $this->bookingRepository->CountBookingByDate(date("Y-m-d"));

        
        
        //graph
        $dataLunch = [5,12,5,8,7,5,7,8,4,5,4,5,6,7,8,9,8,7,5,2,2,0,0,4,5,6,2,4,8,5];
        $dataDinner = [5,8,10,5,5,7,2,7,8,9,5,2,4,2,6,8,7,5,4,5,4,8,5,8,5,4,5,6,5,4];
        $dataDate = ['27/2/2023','28/2/2023','01/03/2023','02/03/2023','03/02/2023','04/03/2023','05/03/2023','06','07','08',
    '09','10','11','14','15','27'];


       

         return $this->render('admin/dashboard.html.twig', [
            'countTodayLunch' => $countTodayLunch,
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
    }
}
