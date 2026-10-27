<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{cityName}', name: 'app_weather')]
    public function city(
        string $cityName,
        LocationRepository $locationRepository,
        MeasurementRepository $measurementRepository
    ): Response {
        $location = $locationRepository->findOneBy(['name' => $cityName]);

        if (!$location) {
            throw $this->createNotFoundException('Lokalizacja nie została znaleziona.');
        }

        $measurements = $measurementRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
