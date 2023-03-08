<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\BookingRepository;
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
           'bookings' => $bookingRepository->findBy(['customer' => $this->getUser()])
        ]);
    }

    #[Route('/customer/account/modify', name: 'app_customer_modify')]
    public function modify(Request $request, EntityManagerInterface $em):Response
    {
        $customer = $this->getUser();

      

        dd($customer);

        $allergy = $request->get('allergy');
        $number = $request->get('person');

        dd($allergy);
        
    }
}
