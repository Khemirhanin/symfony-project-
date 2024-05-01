<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/updateProfile', name: 'app_user')]
    public function index(): Response
    {
        $user= new Users();
        $form=$this->createForm(UserInfoType::class,$user);
        return $this->render('user/updateProfile.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
