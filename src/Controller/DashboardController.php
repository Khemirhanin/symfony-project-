<?php

namespace App\Controller;

use App\Repository\RecipesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/statistics', name: 'statistics')]
    public function index(RecipesRepository $recipesRepository , UsersRepository $usersRepository): Response
    {
        $totalRecipes = $recipesRepository->findAll();
        $totalRequests = $recipesRepository->findRequests();

        $totalUsers = $usersRepository->findAll();
        $connectedUsers = $usersRepository->findConnectedUsers();

        return $this->render('dashboard/adminDashboard.html.twig', [
            'controller_name' => 'DashboardController',
            'totalRecipes' => $totalRecipes,
            'totalRequests' => $totalRequests,
            'totalUsers' => $totalUsers,
            'connectedUsers' => $connectedUsers,
        ]);
    }

}
