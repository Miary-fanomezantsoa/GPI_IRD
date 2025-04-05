<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=>"Votre addresse email",
                'constraints'=>[
                    new Length([
                        'min'=>9,
                        'max'=>40
                    ])
                ],
                'attr'=>[
                    'placeholder'=>"Indiquer votre email",
                    
                ],
                'label_attr' => [
                    'class' => 'h5' // Applique la classe CSS "h3" au <label>
                ]
            ])  
            ->add('plainPassword',RepeatedType::class,[
                'type'=>PasswordType::class,
                'constraints'=>[
                    new Length([
                        'min'=>5,
                        'max'=>30
                    ])
                ],
                'first_options'=>[
                    'label'=> 'Mot de passe',
                     'hash_property_path'=>'password',
                     'attr'=>[
                    'placeholder'=>"Saisiser votre mots de passe"
                ],
                'label_attr' => [
                    'class' => 'h5' // Applique la classe CSS "h3" au <label>
                ]
                    ],
                'second_options'=>[
                    'label'=>'Confirmation ',
                    'attr'=>[
                    'placeholder'=>"Confirmer votre mots de passe"
                ],
                'label_attr' => [
                    'class' => 'h5' // Applique la classe CSS "h3" au <label>
                ]   
                ],
                'mapped'=>false,
            ])
            ->add('firstname',TextType::class,[
                'label'=>"Entrer votre Prenom",
                'constraints'=>[
                    new Length([
                        'min'=>2,
                        'max'=>30
                    ])
                ],
                'attr'=>[
                    'placeholder'=>"Indiquer votre Prenom"
                ],
                'label_attr' => [
                    'class' => 'h5' // Applique la classe CSS "h3" au <label>
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>"Entrer votre Nom",
                'constraints'=>[
                    new Length([
                        'min'=>2,
                        'max'=>30
                    ])
                ],
                'attr'=>[
                    'placeholder'=>"Indiquer Nom"
                ],
                'label_attr' => [
                    'class' => 'h5' // Applique la classe CSS "h3" au <label>
                ]
            ])
            ->add('class',TextType::class,[
                'label'=>"Quel est votre classe",
                'constraints'=>[
                    new Length([
                        'min'=>2,
                        'max'=>7
                    ])
                ],
                'attr'=>[
                    'placeholder'=>"Indiquer votre Classe           "
                ],
                'label_attr' => [
                    'class' => 'h5' // Applique la classe CSS "h3" au <label>
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=>"Envoyer",
                'attr'=>[
                    'class'=>'btn btn-success'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints'=>[
                new UniqueEntity([
                    'entityClass'=>User::class,
                    'fields'=>'email'
                ])
                ],
            'data_class' => User::class,
        ]);
    }
}
