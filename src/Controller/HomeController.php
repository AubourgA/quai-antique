<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(GalleryRepository $galleryRepository): Response
    {

        $sliders = $galleryRepository->findAll();
       
    
        return $this->render('home/index.html.twig', [
            'sliders' => $sliders,
        ]);
    }
    #[Route('/information/legal', name: 'app_info_legal')]
    public function mention(): Response
    {
        return $this->render('home/information/legal.html.twig');
    }

    #[Route('/information/confidentiality-policy', name: 'app_info_policy')]
    public function confidentiality(): Response
    {
        return $this->render('home/information/confidentiality.html.twig');
    }

}
