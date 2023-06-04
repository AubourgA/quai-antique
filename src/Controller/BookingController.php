<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Form\BookingType;
use App\Services\CalendarUtils;
use App\Repository\BookingRepository;
use App\Repository\ScheduleRepository;
use App\Services\CheckPlaceUtils;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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
                            MailerService $mailerService,
                            CheckPlaceUtils $checkPlaceUtils
                            ):Response
    {
        $booking = new Booking;

        //display info user if exist
        if($this->getUser()) {
            $booking->setNumberPerson($this->getUser()->getDefaultPerson());
            $booking->setAllergy($this->getUser()->getAllergy());
        }
        
        $form = $this->createForm(BookingType::class, $booking);
       
        
        $form->handleRequest($request);       
        if($form->isSubmitted() && $form->isValid()) {
           
            //check place is available
            if(!$checkPlaceUtils->isAvailable($form->get('Date')->getData(),$form->get('time')->getData(), $form->get('numberPerson')->getData() - 1)) {
              $this->addFlash('alert', 'Place indisponible. Choisir autre date');
             return $this->redirectToRoute('app_booking_step2');
            }

            $booking->setCustomer($this->getUser());
            $data = $form->getData();
            //check right time enter by user

            // dd(in_array(date_format($data->gettime(),"H:i"),["13:00","20:00","20:15"]));
            $em->persist($data);
            $em->flush();

            try {

                $mailerService->sendEmail(
                                            $booking->getCustomer()->getEmail(),
                                            'Le Quai Antique : Demande de réservation',
                                            'email/confirm.html.twig',
                                            ['date' => $data->getDate(),
                                            'time' => $data->getTime(),
                                            'nb'=> $data->getNumberPerson() ]
                                         );
            } catch(TransportExceptionInterface $e) {
               return $this->render('bundles/TwigBundle/Exception/mailError.html.twig', ['error' => $e->getMessage()]);
            }

            return $this->redirectToRoute('app_booking_step3');
            
        }

        return $this->render('booking/secondstep.html.twig', [
            'form' => $form->createView(),
            'currentMonth' => $calendar->toString(),
            'showCalendar' => $calendar->show(),
        ]);
    }


    #[Route('/booking/confirm', name: 'app_booking_step3')]
    public function step3(BookingRepository $bookingRepository): Response
    {
        
        if($this->getUser()) {
            $lastBooking = $bookingRepository->findOneBy(['customer' => $this->getUser()],['id' => 'DESC']);
  
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
                              CheckPlaceUtils $checkPlace
                              ): Response
    {

        if(!$checkPlace->isAvailable($date,$hour)) {
            return $this->json( ['isAvailable' => false], 200);
        }

        
        return $this->json(['isAvailable' => true],200);
    }




}
