<?php

namespace App\Controller;
use App\Service\PdfService;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Recipes;

class RecipeController extends AbstractController
{
    #[Route('/recipeDetails/{recipeId}', name: 'recipeDetails')]
    public function recipeDetails(ManagerRegistry $doctrine,$recipeId): Response
    {
        $recipe = $doctrine->getRepository(Recipes::class)->find($recipeId);
        if (!$recipe) {
            return $this->redirectToRoute('recipes');        }
        return $this->render('recipe/recipeDetails.html.twig', [
            'recipe' => $recipe,
            'reviews' => $recipe->getReviews()
        ]);
    }
    #[Route('/generatePdf/{recipeId}', name: 'generatePdf')]
    public function index(ManagerRegistry $doctrine,$recipeId)
    {
        $recipe = $doctrine->getRepository(Recipes::class)->find($recipeId);
        if(!$recipe){
            return $this->redirectToRoute('recipes');
        }
        $pdf=new PdfService();
        $recipeImagePath ='img/recepie/'.$recipe->getImage(); // Assuming the recipe image is located in the project directory

        // Encode image files to base64
        $recipeImageBase64 = base64_encode(file_get_contents($recipeImagePath));

        $html = $this->renderView('recipe/recipePdf.html.twig', [
            'recipe' => $recipe,
            'recipeImage' => $recipeImageBase64,
        ]);

        $pdf->showPdf($html,$recipe->getName());

    }
}
