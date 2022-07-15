<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Repository\DepensesRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\PatientRepository;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DefaultController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_dashboard')]
    public function index(ChartBuilderInterface $builder,PatientRepository $patientRepo, OrdonnanceRepository $ordonnanceRepo,DepensesRepository $depensesRepo): Response
    {
        $chart = $builder->createChart(Chart::TYPE_LINE);

        foreach ($ordonnanceRepo->getPriceWeekly() as $day){
            $prices[] = $day['pr'];
            $week[] = 'x';
        }

        $chart->setData([
            'labels' => $week??[],
            'datasets' => [
                [
                    'label' => 'Bénifices',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $prices??[]
                ],
            ],
        ]);

        $price = $ordonnanceRepo->getPriceToDay();

        $patients = $patientRepo->findByAttend();

        return $this->render('default/index.html.twig', [
            'chart' => $chart,
            'nbrPatientsRendezvous'=>count($patientRepo->findByRendezVous()),
            'nbrPatientsAttend'=>count($patientRepo->findByAttend()),
            'totalDepenses'=>(count($depensesRepo->findAll()).' DH'),
            'nbrBenifices'=>(array_values($price[0])[0]).' DH',
            'patients'=>$patients
        ]);
    }
}
