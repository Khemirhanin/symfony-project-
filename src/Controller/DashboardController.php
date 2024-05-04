<?php

namespace App\Controller;

use App\Entity\Reviews;
use App\Repository\RecipesRepository;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private \Doctrine\Persistence\ObjectManager $manager;

    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
    }
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
    #[Route('/requests', name: 'requests')]
    public function requests(RecipesRepository $recipesRepository): Response
    {
        $totalRequests = $recipesRepository->findRequests();

        return $this->render('dashboard/requests.html.twig', [
            'controller_name' => 'DashboardController',
            'totalRequests' => $totalRequests
        ]);
    }
    #[Route('/acceptRequest/{id}', name: 'acceptRequest')]
    public function acceptRequest(RecipesRepository $recipesRepository, $id): Response
    {
        $recipe = $recipesRepository->find($id);
        $recipe->setConfirm(1);
        $this->manager->persist($recipe);
        $this->manager->flush();
        return $this->redirectToRoute('requests');
    }
    #[Route('/deleteRequest/{id}', name: 'deleteRequest')]
    public function deleteRequest(RecipesRepository $recipesRepository, $id): Response
    {
        $this->manager->remove($recipesRepository->find($id));
        $this->manager->flush();
        return $this->redirectToRoute('requests');
    }
    #[Route('/requestDetails/{id}', name: 'requestDetails')]
    public function requestDetails(RecipesRepository $recipesRepository, $id): Response
    {
        $request = $recipesRepository->find($id);
        return $this->render('dashboard/requestDetails.html.twig', [
            'request' => $request
        ]);
    }
}
