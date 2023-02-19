<?php

namespace App\Controller;

use Entity\Entree;
use App\Repository\EntreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealsController extends AbstractController
{
    #[Route('/meals', name: 'app_meals')]
    public function index(EntreeRepository $entreeRepository): Response
    {

        $entrees = $entreeRepository->findBy(['isActive' => 1]);
        
        
        return $this->render('meals/index.html.twig', [
            'entrees' => $entrees,
        ]);
    }
}
