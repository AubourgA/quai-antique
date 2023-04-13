<?php

namespace App\Services;



class CalendarUtils
{

    private int $month;
    private int $year;

    private $months = ['janvier', 'février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
  
    public function __construct(?int $month = null, ?int $year = null)
    {
        if($month === null) {
            $month = intval(date('m'));
        }

        if($year === null) {
            $year = intval(date('Y'));
        }

       $this->month = $month;
       $this->year = $year;
    }


    /**
     * return first date of current month
     *
     * @return \DateTime
     */
    public function getFirstDay(): \DateTime
    {
        return new \DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * return number of days in current month
     *
     * @return integer
     */
    public function getDays():int
    {
        $start = $this->getFirstDay();
        $end = (clone $start)->modify('+1 month - 1 day');

        return intval($end->format('d'));
    }


    /**
     * return diff between 
     *
     * @return integer
     */
    public function getLastMonthDays():int
    {

        $firstMonday = intval($this->getFirstDay()->modify(' last monday')->format('d'));
       
       
        if($firstMonday > 24) {
            $nbDaysLastMonth  = intval($this->getFirstDay()->modify('- 1 day')->format('d'));
            return  $nbDaysLastMonth - $firstMonday + 1;
        }

        return 0;

    }

    public function getIteration():int
    {
        return $this->getDays() + $this->getLastMonthDays();
    }

    /**
     * return array with all number day for current month
     *
     * @return array
     */
    public function show():array
    {
        $item = [];
        $start =  $this->getFirstDay()->modify('last monday');
        
       
        for( $i = 0; $i < $this->getIteration(); $i++) {
            //starting at least 1 day in first week
            if( $start->format('d') > 24  ) {
                $item[] = (clone $start)->modify("+$i days")->format('d');
            } else {
                $item[] = $this->getFirstDay()->modify(" +$i days")->format('d'); 
            }
        }

        return $item;
    }


    public function toString()
    {
        return $this->months[$this->month - 1].' '.$this->year;
    }


    /**
     * return severial time for booking
     *
     * @param [type] $openingTime : start service
     * @param [type] $closedTime : end service
     * @param [type] $min : period for each service
     * @return array
     */
    public function getPeriodTime($openingTime, $closedTime,$min):array
    {
        
        $from_time = strtotime("$openingTime"); 
        $to_time = strtotime("$closedTime");
        $retrait_heur = strtotime("-1 hour", $to_time);
 
        //calcul minute
        $diff_minutes = round(abs(  ($from_time - $retrait_heur )  / 60));
        
        //calcul quart dh'eure
        $nbPlage = $diff_minutes / $min;
        
        $tab = [];
        //display plage
        for($i=0; $i<=$nbPlage; $i++) {
            $taux = $i * $min;
            $tab[] = $this->addMinutes("$openingTime", "$taux");
           
        }
        return $tab;
   }

   /**
    * increase opening hour with period betweening start and end service
    *
    * @param [type] $hour
    * @param [type] $period
    * @return void
    */
    private function addMinutes($hour, $period)
    {
        $timestamp = strtotime("$hour");
        $schedule = strtotime("+$period minutes", $timestamp);
        return $schedule = date('H:i', $schedule);
    }
    
}