<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ReservationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      /*  $reservation = new Reservation();
        $reservation->setCreatedAt('');

        $manager->persist($reservation);

        $manager->flush();*/
    }
}
