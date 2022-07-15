<?php

namespace App\Controller;

use App\Entity\Attend;
use App\Entity\Consultation;
use App\Entity\Patient;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/consultation')]
class ConsultationController extends AbstractController
{
    #[Route('/{id}/new', name: 'consultation_new_by_patient', methods: ['GET', 'POST'])]
    public function newByConsult(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        $consultation = new Consultation();
        $consultation->setPatient($patient);
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($patient->getAttend()!=null){
                $patient->getAttend()->setIsPassed(true);
            }
            $consultation->setPatient($patient);
            $consultation->setDateConsultation(new \DateTime());
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('patient_show', ['id'=>$consultation->getPatient()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consultation/new.html.twig', [
            'consultation' => $consultation,
            'formCons' => $form,
        ]);
    }

    #[Route("/{id}/edit/", name: "consultation_edit")]
    public function edit(Consultation $consultation, Request $request, EntityManagerInterface $entityManager) {

        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('patient_show', ['id'=>$consultation->getPatient()->getId()], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm("consultation/new.html.twig", [
           "formCons" => $form,
           "consultation" => $consultation
        ]);
    }

    #[Route('/attend/{id}/new', name: 'consultation_new_by_attend', methods: ['GET', 'POST'])]
    public function newByAttend(Request $request, ?Attend $attend, EntityManagerInterface $entityManager): Response
    {
        $consultation = new Consultation();
        $consultation->setPatient($attend?->getPatient());
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attend->setIsPassed(true);
            $consultation->setPatient($attend->getPatient());
            $consultation->setDateConsultation(new \DateTime());
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('patient_attend');
        }

        return $this->renderForm('consultation/new.html.twig', [
            'consultation' => $consultation,
            'formCons' => $form,
        ]);
    }
}
