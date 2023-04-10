<?php

namespace App\Services;

use App\Repository\BookingRepository;
use App\Repository\CapacityRepository;

class CheckPlaceUtils
{
    public function __construct(private BookingRepository $bookingRepository, 
                                private CapacityRepository $capacityRepository
    )
    {    }

    /**
     * Check if nb current place is available for booking
     *
     * @param datetime|string $date
     * @param datetime|string $hour
     * @param integer|null $nb
     * @return boolean
     */
    public function isAvailable($date, $hour, ?int $nb = 0):bool
    {
        if($date instanceof \DateTime || $hour instanceof \DateTime) {
           $date = $date->format('Y-m-d');
           $hour = $hour->format('H:i');
        }

     
         //define time to determine time period
       $hour_ref = date("H:i", strtotime("16:00"));
       $hourtime = date("H:i", strtotime("$hour"));
       
       //get limit capacity
        $limit = $this->capacityRepository->findOneBy(['id' => 1]);
        $nbbooks = 0;
        //condition in fonction lunch or dinner
        if($hourtime < $hour_ref) {
            $nbbooks = $this->bookingRepository->countByLunchDay($date, $hour_ref);
            if ( ($nbbooks + $nb) >= $limit->getLunchLimit()) return false;
        }
        
        if($hourtime > $hour_ref) {  
            $nbbooks = $this->bookingRepository->countByDinnerDay($date, $hour_ref);
            if( ($nbbooks + $nb) >= $limit->getDinnerLimit()) return false;
         }

        return true;
    }

}