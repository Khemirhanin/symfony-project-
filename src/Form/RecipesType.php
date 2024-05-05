<?php

namespace App\Form;

use App\Entity\Recipes;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;

class RecipesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('Name', TextType::class, [
            'label' => 'Recipe Name',
            'attr' => [
                'class' => 'form-control w-100',
                'placeholder' => 'Enter recipe name',
                'id' => 'recipe_name',
            ],
        ])
            ->add('Type', ChoiceType::class, [
                'label' => 'Dish Type',
                'choices' => [
                    'Main Dish' => 'Main Dish',
                    'Side Dish' => 'Side Dish',
                    'Appetizer' => 'Appetizer',
                    'Soup' => 'Soup',
                    'Salad' => 'Salad',
                    'Dessert' => 'Dessert',
                    'Drink' => 'Drink',
                ],
                'placeholder' => 'Open this select menu',
                'attr' => [
                    'class' => 'form-select form-select-sm',
                    'id' => 'dish_type',
                ],
            ])
            ->add('NbServings', IntegerType::class, [
                'label' => 'No. of Servings',
                'attr' => [
                    'class' => 'form-control w-100',
                    'placeholder' => 'ex: 4',
                    'id' => 'nb_serv',
                ],
            ])
            ->add('Time', TextType::class, [
                'label' => 'Cooking Time',
                'attr' => [
                    'class' => 'form-control w-100',
                    'placeholder' => 'ex: 45 mins',
                    'id' => 'cookingTime',
                ],
            ])
            ->add('Difficulty', ChoiceType::class, [
                'label' => 'Difficulty',
                'choices' => [
                    'easy' => 'Easy',
                    'moderate' => 'Moderate',
                    'hard' => 'Hard',
                ],
                'expanded' => true,  // Display as radio buttons
                'multiple' => false, // Allow selection of only one difficulty level
                'attr' => [
                    'id' => 'difficulty',
                ],
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Image([
                        'maxSize' => '3000k',
                        'mimeTypes' => ['image/*'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide']
                    )
                ],
                'label' => 'Upload dish Image',
                'attr' => [
                    'class' => 'form-control-file',
                    'id' => 'inputGroupFile02',
                    ],

            ])
            ->add('Ingredients', TextareaType::class, [
                'label' => 'Ingredients',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'ingredients',
                    'rows' => 3,
                    'required' => true,
                ],
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'description',
                    'rows' => 3,
                    'required' => true,
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit form',
                'attr' => [
                    'class' => 'button button-contactForm btn_4 boxed-btn',
                    'id' => 'sub',
                    'name' => 'subbtn',
                ],
            ]);
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipes::class,
        ]);
    }
}
