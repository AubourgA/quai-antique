<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\SubscribeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SubscribeController extends AbstractController
{
    #[Route('/subscribe', name: 'app_subscribe')]
    public function index(Request $request, 
                         EntityManagerInterface $em,
                         UserPasswordHasherInterface $passwordHasher): Response
    {

      

        $customer = new Customer;
        
        $form = $this->createForm(SubscribeType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $customer->setPassword($passwordHasher->hashPassword($customer, $form->getData()->getPlainPassword() ));
            $customer->setRoles(["ROLE_CUSTOMER"]);
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('subscribe/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
