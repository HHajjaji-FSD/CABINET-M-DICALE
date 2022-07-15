<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Ordonnance;
use App\Entity\Radio;
use App\Form\OrdonnanceType;
use App\Repository\MedecamentRepository;
use App\Repository\RadioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ordonnance')]
class OrdonnanceController extends AbstractController
{
    #[Route('/{id}/new', name: 'ordonnance_new', methods: ['GET', 'POST'])]
    public function new(Request $request,Consultation $consultation, MedecamentRepository $medecamentRepo, RadioRepository $radioRepo, EntityManagerInterface $entityManager): Response
    {
        $ordonnance = new Ordonnance();
        $ordonnance->setPrixFinal($consultation->getPrix());
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /*$medicOrdo = json_decode($request->get('medicOrdo'));
            foreach ($medicOrdo as $m){

            }*/
            $ordonnance->setDateORD(new \DateTime());
            $ordonnance->setConsultation($consultation);
            $entityManager->persist($ordonnance);
            $consultation->setOrdonnance($ordonnance);
            $entityManager->flush();
            return $this->redirectToRoute('ordonnance_show', ['id'=>$ordonnance->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ordonnance/new.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form,
            'patient'=>$consultation->getPatient(),
        ]);
    }

    #[Route('/const/{id}', name: 'ordonnance_show_by_const', methods: ['GET'])]
    public function showByConst(Consultation $consultation): Response
    {
        return $this->redirectToRoute('ordonnance_show',['id'=>$consultation->getOrdonnance()->getId()]);
    }

    #[Route('/{id}', name: 'ordonnance_show')]
    public function show(Ordonnance $ordonnance)
    {
        return $this->renderForm('ordonnance/show.html.twig',[
           'ordonnance'=>$ordonnance
        ]);
    }

    #[Route('/{id}/download', name: 'ordonnance_download')]
    public function download(Ordonnance $ordonnance)
    {
        $dompdf = new Dompdf();

        $html = $this->render('ordonnance/download.html.twig',[
            'ordonnance'=>$ordonnance
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4');

        $dompdf->render();

        return new Response($dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]));
    }
}
