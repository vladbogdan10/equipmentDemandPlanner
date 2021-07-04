<?php

namespace App\Service;

use DateTime;
use Exception;

class DataService
{
    const INITIAL_EQUIPMENT_STOCK = 10;

    public function getData(array $bookedEquipment, array $returnedEquipment, string $month): array
    {
        $data = [];

        try {
            $date = new DateTime($month);

            $daysInMonth = (int) $date->format('t');
            $numericMonth = $date->format('m');

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $day = $this->dayPrefix($day);
                $dateKey = "$day.$numericMonth";

                $prevDay = $this->dayPrefix($day - 1);
                $prevDateKey = "$prevDay.$numericMonth";

                $booked = $this->findByDate($dateKey, $bookedEquipment);
                $returned = $this->findByDate($dateKey, $returnedEquipment);

                $data[$dateKey] = $this->equipmentData($booked, $returned, $day, $prevDateKey, $data);
            }

            return $data;
        } catch (Exception $e) {
            return  ['error' => $e->getMessage()];
        }
    }

    private function equipmentData(array $booked, array $returned, string $day, string $prevDateKey, array $data): array
    {
        $equipmentData = [];
        $equipmentKeys = ['chairs', 'bedSheets', 'sleepingBags', 'campingTables', 'portableToilets'];

        foreach ($equipmentKeys as $key) {
            $available = $this->castToInt($returned[$key] ?? 0);

            if ($day === '01') {
                $available = $available + self::INITIAL_EQUIPMENT_STOCK;
            } else {
                $available = $available + $data[$prevDateKey][$key]['available'] - $data[$prevDateKey][$key]['booked'];
            }

            $equipmentData[$key] = [
                'booked' => $this->castToInt($booked[$key] ?? 0),
                'available' => $available
            ];
        }

        return $equipmentData;
    }

    private function castToInt(int $value): int
    {
        return $value ?? 0;
    }

    private function dayPrefix(int $day): string
    {
        return $day < 10 ? "0$day" : "$day";
    }

    private function findByDate(string $date, array $bookings): array
    {
        foreach ($bookings as $booking) {
            $stringDate = $booking['date']->format('d.m');

            if ($date === $stringDate) {
                return $booking;
            }
        }

        return [];
    }
}