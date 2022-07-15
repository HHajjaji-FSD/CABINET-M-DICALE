<?php

namespace App\Controller;

use App\Entity\Attend;
use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\PatientRepository;
use App\Repository\RendezVousRepository;
use App\Service\MyOps;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/rendezvous')]
class RendezVousController extends AbstractController
{
    #[Route('/', name: 'rendezvous_index', methods: ['GET'])]
    public function index(Request $request, RendezVousRepository $rendezVousRepo): Response
    {
        if ($request->isXmlHttpRequest()) {
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

        return $this->render('rendezvous/index.html.twig');
    }

    #[Route('/new', name: 'rendezvous_new')]
    public function new(Request                $request,
                        RendezVousRepository   $rendezVousRepository,
                        MyOps $myOps,
                        EntityManagerInterface $entityManager): Response
    {
        /**
         * return $this->json($request);
         *
         * $start = $request->request->get('start');
         * $idPatient = $request->request->get('idPatient');
         * $rendezVou = new RendezVous();
         *
         * $patient = $repo->find($idPatient);
         * $rendezVou->setPatient($patient);
         * $rendezVou->setDateRDV(new \DateTime($start));
         * $rendezVou->setIsConfermed(false);
         * $rendezVou->setDateCreation(new \DateTime());
         *
         * $entityManager->persist($rendezVou);
         * $entityManager->flush();
         **/
        $patientFormShow = false;
        $selectPeriode = $request->get("periode");
        if($selectPeriode) {
            $rendezVous = new RendezVous();
            $form = $this->createForm(RendezVousType::class, $rendezVous);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $rendezVous->setIsConfermed(false);
                $rendezVous->setDateRDV(new \DateTime(substr($selectPeriode,-10)));
                $rendezVous->setPeriode(str_starts_with($selectPeriode,'matin')?1:2);
                $rendezVous->setDateCreation(new \DateTime());
                $entityManager->persist($rendezVous);
                $entityManager->flush();

                return $this->redirectToRoute('patient_show', ['id' => $rendezVous->getPatient()->getId()], Response::HTTP_SEE_OTHER);
            }
            return $this->renderForm("rendezvous/new.html.twig", [
                "form" => $form
            ]);
        }

        return $this->renderForm("rendezvous/blocs/new_calender.html.twig");
    }

    #[Route('/{id}/newbypatient', name: 'rendezvous_new_by_patient', methods: ['GET', 'POST'])]
    public function newByPatient(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        $rendezVou = new RendezVous();
        $rendezVou->setPatient($patient);
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezVou->setPatient($patient);
            $rendezVou->setIsConfermed(false);
            $rendezVou->setDateCreation(new \DateTime());
            $entityManager->persist($rendezVou);
            $entityManager->flush();

            return $this->redirectToRoute('patient_show', ['id' => $patient->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvous/new.html.twig', [
            'rendezvous' => $rendezVou,
            'formRDV' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rendezvous_show', methods: ['GET'])]
    public function show(RendezVous $rendezVou): Response
    {
        $data = [
            'id' => $rendezVou->getId(),
            'dateRDV' => $rendezVou->getDateRDV()->format('Y-m-d H:i:s'),
            'patient' => [
                'id' => $rendezVou->getPatient()->getId(),
                'name' => $rendezVou->getPatient()->__toString(),
            ],
            'hasAttend' => $rendezVou->getPatient()->getAttend() != null
        ];
        return $this->json(['rendezvous' => $data]);
    }

    #[Route('/{id}/edit', name: 'rendezvous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rendezvous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvous/edit.html.twig', [
            'rendezvous' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rendezvous_delete', methods: ['POST'])]
    public function delete(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rendezVou->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rendezvous_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/attend', name: 'rendezvous_attend', methods: ['GET', 'POST'])]
    public function attend(RendezVous $rendezVous, EntityManagerInterface $entityManager): Response
    {
        $rendezVous->setIsConfermed(true);
        $attend = new Attend();
        $attend->setPatient($rendezVous->getPatient());
        $attend->setSequence(0);
        $entityManager->persist($attend);
        $entityManager->flush();

        return $this->redirectToRoute('rendezvous_index', [], Response::HTTP_SEE_OTHER);
    }
}
