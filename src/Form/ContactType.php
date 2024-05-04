<?php

namespace App\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a message',
                    ])
                ]
            ])
            ->add('name',TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your name',
                    ])
                ]

            ])
            ->add('userEmail' , EmailType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your email',
                    ])
                ]
            ])
            ->add('subject', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a subject',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send Message'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here

        ]);
    }
}
