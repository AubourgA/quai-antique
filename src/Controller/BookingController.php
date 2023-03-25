<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\ScheduleRepository;
use App\Services\CalendarUtils;
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
    public function step2(CalendarUtils $calendar):Response
    {
        $booking = new Booking;

        $user = $this->getUser();
        
        if($user) {
            $booking->setNumberPerson($user->getDefaultPerson());
            $booking->setAllergy($user->getAllergy());
        }
        
        $form = $this->createForm(BookingType::class, $booking);
        
       
        
        $currentMonth = $calendar->toString();

        return $this->render('booking/secondstep.html.twig', [
            'form' => $form->createView(),
            'currentMonth' => $currentMonth,
            'showCalendar' => $calendar->show(),
           
            
        ]);
    }
    /**
     * create calendar and return via AJAX
     */
    #[Route('/booking/{month}-{year}', name: 'app_calendar', methods:['GET'])]
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
    #[Route('/booking/time/{day}', name: 'app_boking_time', methods:['GET'])]
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


}
