<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $utils): Response
    {
        $lastUsername = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();
        $user_loged = $this->getUser();

if ($user_loged) {
    return $this->redirectToRoute('app_index');
} 

        return $this->render('login/index.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/loginok', name: 'app_login_ok')]
    public function postLoginRedirectAction(UserRepository $userRepository)
    {
        $user_loged = $this->getUser();
        if ($user_loged){
            $user = $userRepository->findOneBy(
    
                ['email' => $user_loged->getUserIdentifier()]
            
            );
    
            if (in_array('ROLE_ADMIN', $user->getRoles() ) ) {
                print_r($user->getRoles());
                return $this->redirectToRoute('app_admin');
                }
                if (in_array('ROLE_CLIENT', $user->getRoles())) {
                    print_r($user->getRoles());
        
                    return $this->redirectToRoute('app_cliente', ['id' => $user->getId()]);
                } 
                if (in_array('ROLE_GERENTE', $user->getRoles())) {
                    print_r($user->getRoles());        
                    return $this->redirectToRoute('app_gerente', ['gerente' => $user->getId()]);
                }
    
           }
    }
}