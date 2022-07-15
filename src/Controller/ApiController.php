<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Repository\RendezVousRepository;
use App\Service\MyOps;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api")]
class ApiController extends AbstractController
{
    #[Route("/rendezvous")]
    public function getRendezVous(Request $request, RendezVousRepository $rendezVousRepo)
    {
            $start = $request->request->get('start');
            $end = $request->request->get('end');
            $rendezVouses = $rendezVousRepo->findAll();
            $events = [];

            foreach ($rendezVouses as $rendezVous) {
                $events[] = [
                    'id' => $rendezVous->getId(),
                    'title' => $rendezVous?->getPatient()?->__toString(),
                    'start' => $rendezVous->getDateRDV(),
                    'end' => $rendezVous->getDateRDV()
                ];
            }

            return $this->json($events);
    }

    #[Route("/renduVousDate")]
    public function renduVousEntreDate(Request              $request,
                                       RendezVousRepository $rendezVousRepository,
                                       MyOps                $myOps
    )
    {
        $start = new \DateTimeImmutable($request->get("start"));
        $today = new \DateTimeImmutable();
        if($start < $today) {
            $start = $today;
        }
        $end = new \DateTimeImmutable($request->get("end"));
        $setting = $myOps->getSetting();


        $dayData = $this->getDayData($start, $rendezVousRepository);
        $data = $this->getEventsInfos($dayData, $start, $setting->getNumMatin(), $setting->getNumMedi());

        $done = false;
        $interval = new \DateInterval("P1D");
        $day = \DateTime::createFromImmutable($start);
        while ($done == false) {
            $day = $day->add($interval);
            $mut = \DateTimeImmutable::createFromMutable($day);
            $dayData = $this->getEventsInfos($this->getDayData($mut, $rendezVousRepository), $mut, $setting->getNumMatin(), $setting->getNumMedi());
            foreach ($dayData as $dt) {
                array_push($data, $dt);
            }
            //dump($day->format("dmY"), $end->format("dmY"));

            if ($day->format("dmY") == $end->format("dmY")) {
                $done = true;
            }
            //$done = true;
        }
        return $this->json($data);
    }

    private function getEventsInfos(array $data, \DateTimeImmutable $date, int $maxMatin, int $maxMedi): array
    {
        $bgClassMatin = "bg-green";
        $bgClassMedi = "bg-green";

        $matinId = "matin_" . $date->format("d-m-Y");
        $mediId = "medi_" . $date->format("d-m-Y");

        if($data["matin"] >= $maxMatin) {
            $bgClassMatin = "bg-danger";
            $matinId = "block";
        }
        if($data["medi"] >= $maxMedi) {
            $bgClassMatin = "bg-danger";
            $mediId = "block";
        }
        return [
            [
                "id" => $matinId,
                "title" => "Matin (" . $data["matin"] . ")",
                "start" => $date->format("Y-m-d") . " 08:00",
                "end" => $date->format("Y-m-d") . " 12:00",
                "classNames" => [$bgClassMatin],
            ],
            [
                "id" => $mediId,
                "title" => "Medi (" . $data["medi"] . ")",
                "start" => $date->format("Y-m-d") . " 13:00",
                "end" => $date->format("Y-m-d") . " 17:00",
                "classNames" => [$bgClassMedi],
            ],
        ];
    }

    private function getDayData(\DateTimeImmutable $date, RendezVousRepository $rendezVousRepository)
    {
        //Matin
        $matin = $rendezVousRepository->findDayPeriodRenduVous($date, 1);
        $medi = $rendezVousRepository->findDayPeriodRenduVous($date, 2);

        return [
            "matin" => count($matin),
            "medi" => count($medi)
        ];
    }
}