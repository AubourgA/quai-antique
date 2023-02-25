<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Menu;
use App\Entity\Meals;
use App\Entity\Entree;
use App\Entity\Dessert;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      
        
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

        //menu
        for ($i =0; $i < 2; $i++) {
            $menu = new Menu;
            $menu->setTitle('menu'.$i);
            $menu->setPrice(5);
            $menu->setUrlImage( '/img/plat.jpg');
            $menu->setCreatedAt(new \DateTimeImmutable());
            $menu->setIsActive(1);
            $manager->persist($menu);

        }




        $manager->flush();
    }
}
