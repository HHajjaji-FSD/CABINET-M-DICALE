<?php

namespace App\Controller;

use App\Entity\Attend;
use App\Entity\Patient;
use App\Form\AttendType;
use App\Repository\AttendRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/attend')]
class AttendController extends AbstractController
{
    #[Route('/{id}/new', name: 'attend_new', methods: ['GET', 'POST'])]
    public function new(Patient $patient,Request $request, AttendRepository $attendRepo, EntityManagerInterface $entityManager): Response
    {
        $attend = new Attend();
        $attend->setPatient($patient);
        $attend->setIsPassed(false);
        $order = count($attendRepo->findAll());
        $attend->setSequence($order);
        $entityManager->persist($attend);
        $entityManager->flush();

        return $this->redirectToRoute('patient_attend');
    }

    #[Route('/clear', name: 'attend_clear', methods: ['POST'])]
    public function clear(Request $request, AttendRepository $repo, EntityManagerInterface $entityManager): Response
    {
        foreach ($repo->findAll() as $attend){
            $attend->setPatient(null);
            $entityManager->flush();
            $entityManager->remove($attend);
            $entityManager->flush();
        }
        return $this->redirectToRoute('patient_attend');
    }

    #[Route('/{id}/order', name: 'attend_order')]
    public function order(Request $request, Attend $attend, AttendRepository $repo, EntityManagerInterface $entityManager): Response
    {
        $order = $request->request->get('newIndex');
        $oldOrder = $request->request->get('oldIndex');
        $pl = $attend->getSequence()>$oldOrder ? -1 : 1;

        foreach ($repo->findAll() as $at){
            if($at->getSequence()<$oldOrder){
                $at->setSequence($at->getSequence()+$pl);
            }
        }

        $attend->setSequence($order);
        $entityManager->flush();

        return $this->json([
            'msg'=>'success',
            'oldOrder'=>$oldOrder,
            'order'=>$order,
            'att-ord'=>$attend->getSequence()
        ]);
    }

    #[Route('/{id}/delete', name: 'attend_delete', methods: ['POST'])]
    public function delete(Request $request,Attend $attend, AttendRepository $repo, EntityManagerInterface $entityManager): Response
    {
        $attend->setPatient(null);
        $entityManager->flush();
        $entityManager->remove($attend);
        $entityManager->flush();

        return $this->redirectToRoute('patient_attend');
    }
}
