<?php

namespace App\Controller;

use App\Entity\Setting;
use App\Form\SettingType;
use App\Repository\SettingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/admin/profile', name: 'app_profile')]
    public function index(Request $request, SettingRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $setting = $repository->findOneBy([]);
        if($setting == null) {
            $setting = new Setting();
        }
        $form = $this->createForm(SettingType::class, $setting);

        return $this->render('profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/changepassword', name: 'app_change_password')]
    public function changePassword(Request $request,UserPasswordHasherInterface $hasher,UserRepository $repo,EntityManagerInterface $entityManager): Response
    {

        $oldPassword = $request->request->get('oldPassword');
        $newPassword = $request->request->get('newPassword');

        if($hasher->isPasswordValid($this->getUser(),$oldPassword)){
            $user = $repo->findOneBy(['username'=>$this->getUser()->getUserIdentifier()]);

            $user->setPassword($hasher->hashPassword($user,$newPassword));
            $entityManager->flush();


            return $this->redirectToRoute('app_default');
        }

        $this->addFlash('error','old ppassword incorrect');

        return $this->redirectToRoute('app_profile');
    }
}
