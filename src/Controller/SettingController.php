<?php

namespace App\Controller;

use App\Entity\Setting;
use App\Form\SettingType;
use App\Repository\SettingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingController extends AbstractController
{
    #[Route('/setting', name: 'app_setting')]
    public function index(Request $request, SettingRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $setting = $repository->findOneBy([]);
        if($setting == null) {
            $setting = new Setting();
        }
        $form = $this->createForm(SettingType::class, $setting);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($setting);
            $entityManager->flush();
            return $this->redirectToRoute("app_setting");
        }

        return $this->renderForm('setting/index.html.twig', [
            'form' => $form,
        ]);
    }
}
