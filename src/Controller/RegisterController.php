<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use DateTimeImmutable;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entity_manager): Response
    {
        $user=new User;
        $form= $this->createForm(RegisterUserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form-> isValid()){
            $this->addFlash(
                'success',
                'Votre compte est correctement creé veuillez vous connecter'
            );

            $user->setCreatedAt(new DateTimeImmutable());
            $entity_manager->persist($user);        
            $entity_manager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('register/index.html.twig',[
            'form'=> $form->createView(),
        ]);
    }
}
