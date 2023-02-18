<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealsController extends AbstractController
{
    #[Route('/meals', name: 'app_meals')]
    public function index(): Response
    {
        return $this->render('meals/index.html.twig', [
            'controller_name' => 'MealsController',
        ]);
    }
}
