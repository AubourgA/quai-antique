<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
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

    #[Route('/booking/{month}-{year}', name: 'app_calendar')]
    public function getMonth( $month,  $year):Response
    {
        $calendar = new \App\Services\CalendarUtils($month, $year);
        
        
        return $this->render('booking/calendar.html.twig', [
            'calendar' => $calendar->show()
        ]);
    }
}
