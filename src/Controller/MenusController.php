<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenusController extends AbstractController
{
    #[Route('/menus', name: 'app_menus')]
    public function index(MenuRepository $menuRepository): Response
    {

        $menus = $menuRepository->findBy(['isActive'=>1]);
       
        return $this->render('menus/index.html.twig', [
            'menus' => $menus
        ]);
    }
}
