<?php

namespace App\Controller;


use App\Entity\Customer;
use App\Form\CustomerInfoType;
use App\Repository\BookingRepository;
use App\Repository\CustomerRepository;
use App\Services\UpdateCustomerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerAccountController extends AbstractController
{
    #[Route('/customer/account', name: 'app_customer_account')]
    public function index(BookingRepository $bookingRepository, 
                            Request $request, EntityManagerInterface $em,
                            ): Response
    {

       //creation du form partiel
       $customer = $em->getRepository(Customer::class)->find($this->getUser());
       $form = $this->createForm(CustomerInfoType::class, $customer);

        return $this->render('customer_account/index.html.twig', [
           'bookings' => $bookingRepository->findBy(['customer' => $this->getUser()]),
           'nextBooking' =>$bookingRepository->findNextBookingOneBy($this->getUser()),
           'form' => $form->createView()
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
    public function modify(Request $request, EntityManagerInterface $em):Response
    {
       $customer = $em->getRepository(Customer::class)->find($this->getUser());

       $form = $this->createForm(CustomerInfoType::class, $customer);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
           $em->persist($form->getData());
           $em->flush();
           $this->addFlash('success', 'Renseignements actualisés !');
       }

        return  $this->redirectToRoute('app_customer_account');
        
    }
}
