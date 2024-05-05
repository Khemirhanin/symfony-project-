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
    private $repository;

    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
        $this->repository = $this->doctrine->getRepository(Reviews::class);
    }
    #[Route('/review/{recipe_id}', name: 'review', methods: ['GET', 'POST'])]
    public function add(Request $request, $recipe_id): Response
    {
        // ToDo: get user_id from session
        //$session = $request->getSession();
        //$user_id = $session->get('user')['id'];
        $user_id = 1;

        $review = $this->repository->findOneByUserAndRecipe($user_id ,$recipe_id);
        $recipe = $this->doctrine->getRepository(Recipes::class)->find($recipe_id);
        $user = $this->doctrine->getRepository(Users::class)->find($user_id);
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

