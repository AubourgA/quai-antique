<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Form\BookingType;
use App\Services\CalendarUtils;
use App\Repository\BookingRepository;
use App\Repository\CapacityRepository;
use App\Repository\ScheduleRepository;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    #[Route('/booking/indentification', name: 'app_booking')]
    public function step1(): Response
    {
       
        if($this->getUser()) {
            return $this->redirectToRoute('app_booking_step2');
        }
   
        return $this->render('booking/firststep.html.twig', [
        
        ]);
    }

    #[Route('/booking/reserve', name: 'app_booking_step2')]
    public function step2(CalendarUtils $calendar, 
                            Request $request,
                            EntityManagerInterface $em,
                            MailerService $mailerService
                            ):Response
    {
        $booking = new Booking;

        $user = $this->getUser();
        
        if($user) {
            $booking->setNumberPerson($user->getDefaultPerson());
            $booking->setAllergy($user->getAllergy());
        }
        
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()) {
            $booking->setCustomer($user);
            $data = $form->getData();
            $em->persist($data);
            $em->flush();

            // $mailerService->sendEmail($booking->getCustomer()->getEmail(),'Resesrvation','Votre reservation a été réalisé');
            $mailerService->sendEmail('adrien.aubourg@hotmail.fr','Resesrvation','Votre reservation a été réalisé');

            return $this->redirectToRoute('app_booking_step3');
            
        }

        
        $currentMonth = $calendar->toString();

        return $this->render('booking/secondstep.html.twig', [
            'form' => $form->createView(),
            'currentMonth' => $currentMonth,
            'showCalendar' => $calendar->show(),
           
            
        ]);
    }


    #[Route('/booking/confirm', name: 'app_booking_step3')]
    public function step3(BookingRepository $bookingRepository): Response
    {
        
        if($this->getUser()) {
            $lastBooking = $bookingRepository->findOneBy(['customer' => $this->getUser()],['Date' => 'DESC']);
         
        }

        return $this->render('booking/finalstep.html.twig', ['lastbooking' => $lastBooking]);
    }




    /**
     * create calendar and return via AJAX
     */
    #[Route('/booking/{month}-{year}', name: 'app_calendar', methods:['POST'])]
    public function getMonth( $month,  $year):Response
    {
        $calendar = new \App\Services\CalendarUtils($month, $year);
        
        
        return $this->render('booking/calendar.html.twig', [
            'calendar' => $calendar->show()
        ]);
    }

    /**
     * get opening time and return via ajax period for booking
     */
    #[Route('/booking/time/{day}', name: 'app_boking_time', methods:['POST'])]
    public function display( string $day, ScheduleRepository $scheduleRepository, CalendarUtils $calendar):Response
    {
      
        $creneaux = $scheduleRepository->findOneBy(['Day' => $day]);
        
        

        $lunch = $calendar->getPeriodTime(date_format($creneaux->getLunchStart(), 'H:i'),date_format($creneaux->getLunchEnd(), 'H:i'),15);
        $dinner = $calendar->getPeriodTime(date_format($creneaux->getDinnerStart(), 'H:i'),date_format($creneaux->getDinnerEnd(), 'H:i'),15);
       
       
        return $this->render('booking/calendarTime.html.twig', [
          'lunch' => $lunch,
          'dinner' =>$dinner
        ]);
    }

    #[Route('/booking/check/{date}/{hour}', name: 'app_booking_hour', methods:['POST'])]
    public function checkDate($date, 
                              $hour, 
                              BookingRepository $bookingRepository, 
                              CapacityRepository $capacityRepository): Response
    {
        //define time to determine time period
       $hour_ref = date("H:i", strtotime("16:00"));
       $hourtime = date("H:i", strtotime("$hour"));

       //get limit capacity
        $limit = $capacityRepository->findOneBy(['id' => 1]);
        $nbbooks = 0;
        
      //condition in fonction lunch or dinner
       if($hourtime < $hour_ref) {
           $nbbooks = $bookingRepository->countByLunchDay("$date",'16:00');
           if ($nbbooks >= $limit->getLunchLimit()) {
                return $this->json( ['isAvailable' => false], 200);
           } 
        }

       if($hourtime > $hour_ref) {
            $nbbooks = $bookingRepository->countByDinnerDay("$date",'16:00');
            if( $nbbooks >= $limit->getDinnerLimit()) {
            
                return $this->json(['isAvailable' => false, 'nb'=> $nbbooks], 200);
            }     
         }

    return $this->json(['isAvailable' => true],200);
    }
}
