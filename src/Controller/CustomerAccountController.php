<?php

namespace App\Controller;


use App\Repository\BookingRepository;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerAccountController extends AbstractController
{
    #[Route('/customer/account', name: 'app_customer_account')]
    public function index(BookingRepository $bookingRepository): Response
    {

       

        return $this->render('customer_account/index.html.twig', [
           'bookings' => $bookingRepository->findBy(['customer' => $this->getUser()]),
           'nextBooking' =>$bookingRepository->findNextBookingOneBy($this->getUser())
        ]);
    }

    /**
     * Update data from customer
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    #[Route('/customer/account/modify', name: 'app_customer_modify')]
    public function modify(CustomerRepository $customerRepository, Request $request, EntityManagerInterface $em):Response
    {
       
        $customer = $customerRepository->findOneBy(['id' => $this->getUser()]);

        $allergy  = htmlspecialchars($request->get("allergy"));
        $person   = htmlspecialchars($request->get('person'));
        
        if($request->getMethod() === 'POST') {

           
            $customer->setAllergy($allergy);
            $customer->setDefaultPerson($person);
            $em->persist($customer);
            $em->flush();

            $this->addFlash('success', 'Info mise a jour !');
        }


        return  $this->redirectToRoute('app_customer_account');
        
    }
}
