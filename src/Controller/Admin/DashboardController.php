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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //Get all value needed out of booking 
      
        $countToday = $this->bookingRepository->countBooking('16:00', date('Y-m-d'), date('Y-m-d'));
        $count1     = $this->bookingRepository->countBooking('16:00', date('Y-m-d',strtotime('+ 1 day')), date('Y-m-d',strtotime('+ 1 day')));
        $count7     = $this->bookingRepository->countBooking('16:00',date('Y-m-d'), date('Y-m-d',strtotime('+ 7 day')));
  
        //get data for graphic
        $graphData = $this->bookingRepository->countGroupBooking('16:00',date("Y-m-d"),date('Y-m-d',strtotime('- 30 day')));
        
        // get lunch
        
        $dataLunch = [];
        $dataDinner = [];
        $dataDate = [];
        for($i=0; $i< count($graphData); $i++) {
                $dataLunch[] = $graphData[$i]['LUNCH'];
                $dataDinner[] = $graphData[$i]['DINNER'];
               $dataDate[] = $graphData[$i]['Date'];
        }

     

         return $this->render('admin/dashboard.html.twig', [
             'dataLunch' => json_encode($dataLunch),
             'dataDinner' =>json_encode($dataDinner),
             'dataDate' => json_encode($dataDate),
            'countToday' => $countToday,
            'count1'     => $count1,
            'count7'     => $count7,
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
