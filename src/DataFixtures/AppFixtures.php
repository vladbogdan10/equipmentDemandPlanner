<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $stations = ['munich', 'vienna', 'madrid', 'paris', 'porto'];
        $stationsCount = count($stations) - 1;

        $year = date("Y");
        $month = date('m');

        for ($i = 0; $i < 50; $i++) {
            $equipment = [
                'portableToilet' => random_int(0, 5),
                'bedSheet' => random_int(0, 5),
                'sleepingBag' => random_int(0, 5),
                'campingTable' => random_int(0, 5),
                'chair' => random_int(0, 5)
            ];

            $randomDay1 = random_int(1, 28);

            $startDate = new DateTime("$year-$month-$randomDay1");
            $StartDateClone = clone $startDate;
            $endDay = random_int(0, 7);
            $endDate = $StartDateClone->add(new DateInterval("P{$endDay}D"));

            $booking = new Booking();
            $booking->setCampervan('VW');
            $booking->setStartDate($startDate);
            $booking->setEndDate($endDate);
            $booking->setStartStation($stations[random_int(0, $stationsCount)]);
            $booking->setEndStation($stations[random_int(0, $stationsCount)]);
            $booking->setEquipment($equipment);

            $manager->persist($booking);
        }

        $manager->flush();
    }
}
