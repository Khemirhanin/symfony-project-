<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Entity\Recipes;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('layouts/searchBar.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar(){
        $form = $this->createForm(SearchType::class);
        return $this->render('layouts/searchBar.html.twig', [
            'form'=>$form->createView(),
        ]);
    }


}
