<?php

namespace App\Controller;

use App\Repository\DessertRepository;
use Entity\Entree;
use App\Repository\EntreeRepository;
use App\Repository\MealsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealsController extends AbstractController
{
    #[Route('/meals', name: 'app_meals')]
    public function index(EntreeRepository $entreeRepository,
                           MealsRepository $mealsRepository,
                           DessertRepository $dessertRepository
                            ): Response
    {

        $entrees = $entreeRepository->findBy(['isActive' => 1]);
        $meals = $mealsRepository->findBy(['isActive' => 1]);
        $desserts = $dessertRepository->findBy(['isActive' => 1]);
        
        return $this->render('meals/index.html.twig', [
            'entrees' => $entrees,
            'meals' => $meals,
            'desserts' => $desserts
        ]);
    }
}
