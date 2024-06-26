<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Entity\Reviews;
use App\Entity\Users;
use App\Form\ReviewType;
use Doctrine\Persistence\ManagerRegistry;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    private \Doctrine\Persistence\ObjectManager $manager;

    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
    }
    #[Route('/review/{recipe_id}', name: 'review', methods: ['GET', 'POST'])]
    public function add(Request $request, $recipe_id): Response
    {
        $user = $this->getUser();
        $review = $this->doctrine->getRepository(Reviews::class)->findOneByUserAndRecipe($user ,$recipe_id);
        $recipe = $this->doctrine->getRepository(Recipes::class)->find($recipe_id);

        if (!$review) {
            $review = new Reviews();
            $review->setUser($user);
            $review->setRecipe($recipe);
        }

        $form = $this->createForm(ReviewType::class, $review);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($review);
            $this->manager->flush();
            $recipe->updateAverageRating();
            $this->manager->persist($recipe);
            $this->manager->flush();
            return $this->redirectToRoute('recipeDetails', ['recipeId' => $recipe_id ]);
        }

        return $this->render('review/review.html.twig', [
            'form' => $form->createView(),
             'recipe' => $recipe
        ]);
    }
}

