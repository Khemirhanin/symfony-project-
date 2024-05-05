<?php

namespace App\Controller;

use App\Form\SearchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Recipes;
class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/recipes', name: 'recipes')]
    public function recipes(ManagerRegistry $doctrine,Request $request): Response
    {
        $recipes = $doctrine->getRepository(Recipes::class)->findAll();

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();

            $repository = $doctrine->getRepository(Recipes::class);

            $recipes = $repository->findByName($search);

            return $this->render('home/recipes.html.twig', [
                'recipes' => $recipes,
            ]);
        }
        return $this->render('home/recipes.html.twig', [
            'recipes' => $recipes,
        ]);
    }
}
