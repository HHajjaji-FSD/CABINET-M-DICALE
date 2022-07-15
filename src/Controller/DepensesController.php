<?php

namespace App\Controller;

use App\Entity\Depenses;
use App\Form\DepensesType;
use App\Repository\DepensesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/depenses')]
class DepensesController extends AbstractController
{
    #[Route('/', name: 'depenses_index', methods: ['GET'])]
    public function index(Request $request, DepensesRepository $repo): Response
    {
        $search = $request->get('search');
        $depenses = $repo->findByName($search);

        return $this->render('depenses/index.html.twig', [
            'depenses' => $depenses,
            'last_search'=>$search
        ]);
    }

    #[Route('/new', name: 'depenses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $depense = new Depenses();
        $form = $this->createForm(DepensesType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $depense->setDateCreation(new \DateTime());
            $entityManager->persist($depense);
            $entityManager->flush();

            return $this->redirectToRoute('depenses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depenses/new.html.twig', [
            'depense' => $depense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'depenses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Depenses $depense, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepensesType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('depenses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depenses/edit.html.twig', [
            'depense' => $depense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'depenses_delete', methods: ['POST'])]
    public function delete(Request $request, Depenses $depense, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$depense->getId(), $request->request->get('_token'))) {
            $entityManager->remove($depense);
            $entityManager->flush();
        }

        return $this->redirectToRoute('depenses_index', [], Response::HTTP_SEE_OTHER);
    }
}
