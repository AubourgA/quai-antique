<?php

namespace App\Twig;

use App\Repository\ScheduleRepository;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class ScheduleExtension extends AbstractExtension
{
    
    private $scheduleRepository;
    private $twig;

    public function __construct(ScheduleRepository  $scheduleRepository, Environment $twig)
    {
            $this->scheduleRepository = $scheduleRepository;
            $this->twig = $twig;
        }
    /**
     * create fcn for Twig environment
     *
     * @return array
     */    
    public function getFunctions():array
    {
        return [
            new TwigFunction('opening', [$this, 'getSchedule'], ['is_safe'=> ['html']])
        ];
    }

    /**
     * define fcn : get data from DB and render to view
     *
     * @return string
     */
    public function getSchedule():string
    {
       $schedule =  $this->scheduleRepository->findAll();

       return $this->twig->render('partials/_schedule.html.twig', [
            'schedule' => $schedule
       ]);
    }
}