<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Entity\Users;
use App\Form\UserInfoType;
use Doctrine\Persistence\ManagerRegistry;
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
    #[Route('/viewMyPosts/{userId}', name: 'viewMyPosts')]
    public function Profile($userId,ManagerRegistry $doctrine): Response
    {
        $userRepository=$doctrine->getRepository(Users::class);
        $user=$userRepository->find($userId);
        if($user==null)
        {
            $this->addFlash('danger', "User not found");
            return $this->redirectToRoute('home');
        }
        $RecipeRepository=$doctrine->getRepository(Recipes::class);
        $recipes=$RecipeRepository->findBy(['IdUser'=>$user]);
        return $this->render('user/viewMyPosts.html.twig', [
            'recipes' => $recipes,
            'user'=>$user
        ]);
    }

}
