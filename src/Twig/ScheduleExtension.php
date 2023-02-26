<?php

namespace App\Twig;

use App\Repository\ScheduleRepository;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class ScheduleExtension extends AbstractExtension
{
    private $schedleRepository;

    private $twig;

    public function __construct(ScheduleRepository $scheduleRepository, Environment $twig)
    {
        $this->schedleRepository = $scheduleRepository;
        $this->twig = $twig;
    }
    public function getFunctions():array
    {
        return [
            new TwigFunction('opening', [$this, 'getSchedule'], ['is_safe'=> ['html']])
        ];
    }

    public function getSchedule():string
    {
       $schedule =  $this->schedleRepository->findAll();

       return $this->twig->render('partials/_schedule.html.twig', [
            'schedule' => $schedule
       ]);
    }
}