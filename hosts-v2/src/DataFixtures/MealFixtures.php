<?php

namespace App\DataFixtures;

use App\Entity\Meal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MealFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        

            $meal1 = new meal();
            $meal1->setName('Raclette chez Toto');
            $meal1->setHostTable($this->getReference('host-nantes'));
            $meal1->setCapacity(5);
            $meal1->setPrice(15);
            $meal1->setDate(new \DateTime());
            $meal1->setMenu('Des trucs');
            $meal1->setRemainingCapacity(5);            
            $manager->persist($meal1);
            $manager->flush();
            
            $meal2 = new meal();
            $meal2->setName('Fondue chez Titi');
            $meal2->setHostTable($this->getReference('host-rennes'));
            $meal2->setCapacity(6);
            $meal2->setPrice(35);
            $meal2->setDate(new \DateTime());
            $meal2->setMenu('Des machins');
            $meal2->setRemainingCapacity(6);            
            $manager->persist($meal2);
            $manager->flush();
            
            $meal3 = new meal();
            $meal3->setName('Tartiflette chez Tata');
            $meal3->setHostTable($this->getReference('host-paris'));
            $meal3->setCapacity(7);
            $meal3->setPrice(55);
            $meal3->setDate(new \DateTime());
            $meal3->setMenu('Des choses');
            $meal3->setRemainingCapacity(7);            
            $manager->persist($meal3);
            $manager->flush();

    }

    public function getDependencies()
    {
        return [HostTableFixtures::class];
    }
}