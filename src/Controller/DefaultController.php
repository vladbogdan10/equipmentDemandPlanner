<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Service\DataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/api/{station}", name="api_route")
     */
    public function data(Request $request, $station, DataService $dataService): Response
    {
        $station = strtolower($station);
        $data = $this->getDashboardData($dataService, $station, $this->getMonthQuery($request));

        return $this->json($data);
    }

    /**
     * @Route("/dashboard/{station}", name="dashboard_route")
     */
    public function dashboard(Request $request, $station, DataService $dataService): Response
    {
        $station = strtolower($station);
        $data = $this->getDashboardData($dataService, $station, $this->getMonthQuery($request));

        return $this->render('dashboard.html.twig', [
            'data' => $data,
            'station' => $station
        ]);
    }

    private function getMonthQuery(Request $request)
    {
        return $request->query->get('month') ?? '';
    }

    private function getDashboardData(DataService $dataService, string $station, string $month): array
    {
        /**
         * @var BookingRepository $bookingRepo
         */
        $bookingRepo = $this->getDoctrine()->getRepository(Booking::class);
        $bookedEquipment = $bookingRepo->getTotalEquipmentBooked($station);
        $returnedEquipment = $bookingRepo->getTotalReturnedEquipment($station);

        return $dataService->getData($bookedEquipment, $returnedEquipment, $month);
    }
}