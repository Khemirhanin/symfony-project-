<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Form\RecipesType;
use App\Form\RecipeType;
use App\Repository\RecipesRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
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
    #[Route('/editRecipe/{id?0}', name: 'editRecipe')]
    public function editRecipe(Request $request,
                               ManagerRegistry $doctrine,
                               EntityManagerInterface $manager,
                               Recipes $recipe = null): Response
    {
        // If no recipe was found, create a new one
        if (!$recipe) {
            $recipe = new Recipes();
        }

        $form = $this->createForm(RecipesType::class, $recipe);

        $form->handleRequest($request);
        $img = $form['image']->getData();
        if($form->isSubmitted() && $form->isValid()){
            $filename = uniqid('', true).'.'.$img->guessExtension();
            if($img->move($this->getParameter('kernel.project_dir').'/public/img/recepie',$filename)){
                $recipe->setImage($filename);
                $recipe->setConfirm(1);
                $recipe->setAverageRating(0);
                $manager->persist($recipe);
                $manager->flush();


            }
            return $this->redirectToRoute('recipesCrud');
        }

        return $this->render('dashboard/editRecipe.html.twig', [
            'contactForm' => $form->createView(),
            'recipe' => $recipe,
        ]);

    }
    #[Route('/deleteRecipe/{id}', name: 'deleteRecipe')]
    public function deleteRecipe(ManagerRegistry $doctrine,Recipes $recipe = null): Response
    {
        if (!$recipe) {
            $this->addFlash('danger', "Recipe not found");
            return $this->redirectToRoute('recipesCrud');
        }
        $entityManager = $doctrine->getManager();
        $entityManager->remove($recipe);
        $entityManager->flush();
        return $this->redirectToRoute('recipesCrud');
    }
    #[Route('/recipesCrud', name: 'recipesCrud')]
    public function recipesCrud(RecipesRepository $recipesRepository): Response
    {
        $recipes = $recipesRepository->findAll();
        return $this->render('dashboard/recipeCrud.html.twig', [
            'recipes' => $recipes,
        ]);
    }

}
