<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

    final class LoginController extends AbstractController
    {
        #[Route('/conexion', name: 'app_login')]
        public function index(AuthenticationUtils $authentication_utils): Response
        {
            $error=$authentication_utils->getLastAuthenticationError();
            $lastUsername=$authentication_utils->getLastUsername();
            return $this->render('login/index.html.twig', [
                'error' => $error,
                'last_username' => $lastUsername,

            ]);
        }
        #[Route('/deconexion', name: 'app_logout',methods:['Get'])]
    
        public function logout(): never
        {
            throw new \Exception('Don\'t forget');      
        }
    }
