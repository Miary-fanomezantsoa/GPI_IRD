<?php

namespace App\Form;

use App\Entity\User;
use ContainerKQdxkzz\getPasswordUserTypeService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use function Sodium\add;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPasword', passwordType::class,[
                'label'=>"Votre mot de passe actuel",
                'attr'=>[
                    'placeholder'=>"Entrez votre mot de passe actuel",
                ],
                'mapped'=>false,
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
                        'placeholder'=>"Saisiser votre nouveau mot de passe"
                    ],
                    'label_attr' => [
                        'class' => 'h5' // Applique la classe CSS "h3" au <label>
                    ]
                ],
                'second_options'=>[
                    'label'=>'Confirmation                          ',
                        'attr'=>[
                            'placeholder'=>"Confirmer votre nouveau mot  de passe"
                        ],
                    'label_attr' => [
                        'class' => 'h5' // Applique la classe CSS "h3" au <label>
                    ]
                ],
                'mapped'=>false,
            ])
            ->add('submit', SubmitType::class,[
                'label'=>"Envoyer",
                'attr'=>[
                    'class'=>'btn btn-success'
                ]
            ])
            ->addEventListener(FormEvents::SUBMIT,function (FormEvent $event){
                $form=$event->getForm();
                $user=$form->getConfig()->getOption('data');
                $actualPasword=$form->get('actualPasword')->getData();
                $passwordHasher=$form->getConfig()->getOption('passwordHasher');
                $isvalid=$passwordHasher->isPasswordValid($user,$actualPasword);
                $actualPasworDatabase=$user->getPassword();
                if (!$isvalid){
                    $form->get('actualPasword')->addError(new FormError('Mot de passe actuel invalide'));
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher'=>null
        ]);
    }

    private function getPassword()
    {
    }
}
