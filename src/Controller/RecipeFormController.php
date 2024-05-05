<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Form\RecipesType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class RecipeFormController extends AbstractController
{
    #[Route('/form', name: 'app_recipe_form')]
    public function index(EntityManagerInterface $manager,Request $request): Response
    {
        $recepie = new Recipes();
        $form = $this->createForm(RecipesType::class,$recepie);
        $form->handleRequest($request);
        $img = $form['image']->getData();
        if($form->isSubmitted() && $form->isValid()){
            $filename = uniqid().'.'.$img->guessExtension();
            if($img->move($this->getParameter('kernel.project_dir').'/public/img/recepie',$filename)){
                $recepie->setImage($filename);
                $recepie->setConfirm(0);
                $recepie->setAverageRating(0);

                $manager->persist($recepie);
                $manager->flush();

                $this->addFlash('success', 'Recipe submitted successfully!');
                return $this->redirectToRoute('app_recipe_form');
            }
            else
                $this->addFlash('danger', 'Error while uploading file!');

        }

        return $this->render('recipe_form/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
