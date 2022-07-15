<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/patient')]
class PatientController extends AbstractController
{
    #[Route('/', name: 'patient_index', methods: ['GET'])]
    public function index(Request $request,PatientRepository $repo, PaginatorInterface $paginator): Response
    {
        $search = $request->get('search');
        $query = $repo->findByFullName($search);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');

        return $this->render('patient/index.html.twig', [
            'pagination' => $pagination,
            'last_search'=>$search
        ]);
    }

    #[Route('/rendezvous', name: 'patient_rendezvous', methods: ['GET'])]
    public function rendezvous(Request $request,PatientRepository $repo, PaginatorInterface $paginator): Response
    {
        $search = $request->get('search');
        $query = $repo->findByRendezVous($search);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');

        return $this->render('patient/index.html.twig', [
            'pagination' => $pagination,
            'last_search'=>$search
        ]);
    }

    #[Route('/archive', name: 'patient_archive', methods: ['GET'])]
    public function archive(Request $request,PatientRepository $repo, PaginatorInterface $paginator): Response
    {
        $search = $request->get('search');
        $query = $repo->findByArchive($search);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');

        return $this->render('patient/index.html.twig', [
            'pagination' => $pagination,
            'last_search'=>$search
        ]);
    }

    #[Route('/attend', name: 'patient_attend', methods: ['GET'])]
    public function attend(Request $request,PatientRepository $repo, PaginatorInterface $paginator): Response
    {
        $search = $request->get('search');
        $patients = $repo->findByAttend($search);

        return $this->render('attend/index.html.twig', [
            'patients' => $patients,
            'last_search'=>$search
        ]);
    }

    #[Route('/new', name: 'patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        $frameId = $request->headers->get("Turbo-Frame");


        if ($form->isSubmitted() && $form->isValid()) {
            $patient->setDateCreation(new \DateTime());
            $entityManager->persist($patient);
            $entityManager->flush();
            if($frameId != "nouveau-patient") {
                return $this->redirectToRoute('patient_show', ['id'=>$patient->getId()], Response::HTTP_SEE_OTHER);
            } else {
                return new Response("<turbo-frame id='nouveau-patient' data-patient-id='".$patient->getId()."'>Success</turbo-frame>");
            }
        }

        return $this->renderForm($frameId == "nouveau-patient" ? 'patient/blocs/_new_renduvous.html.twig' : 'patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('patient_show', ['id'=>$patient->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }
        return $this->redirectToRoute('patient_index', [], Response::HTTP_SEE_OTHER);
    }

    public function Search(Request $request, Patient $patient, ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {


        }
        return $this->redirectToRoute('patient_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/json', name: 'patient_index_json', methods: ['GET'])]
    public function indexJson(PatientRepository $repo): Response
    {
        $patients = $repo->findAll();
        $data = [];
        foreach ($patients as $patient){
            $data[] = [
                'id'=>$patient->getId(),
                'name'=>$patient->__toString(),
            ];
        }

        return $this->json($data);
    }
}

