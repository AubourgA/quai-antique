<?php

namespace App\DataFixtures;

use App\Entity\Dessert;
use App\Entity\Entree;
use App\Entity\Meals;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        //entree
        for ($i =0; $i < 4; $i++) {
            $entrees = new Entree;
            $entrees->setTitle('exmple1'.$i);
            $entrees->setDescription('exemple'.$i);
            $entrees->setPrice(rand(5,20));
            $entrees->setCreatedAt(new \DateTimeImmutable());
            $entrees->setIsActive(1);
            $manager->persist($entrees);

        }

              //plat
              for ($i =0; $i < 4; $i++) {
                $meals = new Meals;
                $meals->setTitle('meals1'.$i);
                $meals->setDescription('meals'.$i);
                $meals->setPrice(rand(5,20));
                $meals->setCreatedAt(new \DateTimeImmutable());
                $meals->setIsActive(1);
                $manager->persist($meals);
    
            }

                  //dessert
                  for ($i =0; $i < 4; $i++) {
                    $desserts = new Dessert;
                    $desserts->setTitle('dessert'.$i);
                    $desserts->setPrice(5);
                    $desserts->setCreatedAt(new \DateTimeImmutable());
                    $desserts->setIsActive(1);
                    $manager->persist($desserts);
        
                }

        $manager->flush();
    }
}
