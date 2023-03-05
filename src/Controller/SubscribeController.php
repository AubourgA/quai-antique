<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\SubscribeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscribeController extends AbstractController
{
    #[Route('/subscribe', name: 'app_subscribe')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

      

        $customer = new Customer;
        
        $form = $this->createForm(SubscribeType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $customer->setPassword(password_hash($form->getData()->getPlainPassword(), PASSWORD_DEFAULT));
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
