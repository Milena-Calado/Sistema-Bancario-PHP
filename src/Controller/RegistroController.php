<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Conta;
use App\Form\RegistrationFormType;
use App\Repository\ContaRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
   
    #[Route('/registro', name: 'app_registro')]
    public function registro(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, ContaRepository $contaRepository): Response
    {
        $user_loged = $this->getUser();
        

       if ($user_loged){
        $us = $userRepository->findOneBy(['email' => $user_loged->getUserIdentifier()]);
        return $this->redirectToRoute('app_conta_criar', ['user' =>$us->getId() ]);

        
       }

        $user = new User();
        
        $form = $this->createForm(
            RegistrationFormType::class, $user, 
            
        );

        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password

            #if exist user
            
        

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_CLIENT']);

            $cpf = $form->get('cpf')->getData();

            $existUser = $userRepository->findOneBy(['cpf' => $cpf]);
            
            if ($existUser){
                $user = $existUser;
                $contaExistente = $contaRepository->findOneBy(['usuario' => $existUser->getId(),'active' => true]);
                
            }else{
                $contaExistente = false;
            }


            

            if ($contaExistente){
                return $this->redirectToRoute('app_conta_criar', ['user' => $existUser->getId()]);
            }
           
            $entityManager->persist($user);
            

            $agencia = $form->get('conta')->getData();
           # dd($agencia);
            $conta = new Conta();
            if ($existUser){
                $conta->setUsuario($existUser);
            }else{
                $conta->setUsuario($user);
            }
            
            $conta->setSaldo(0);
            $conta->setNumero(rand(100000, 999999));
            $conta->setAgencia($agencia->getAgencia());
            $conta->setTipo($agencia->getTipo());

                   
            

            $entityManager->persist($conta);
           

            $entityManager->flush();

            
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registro/index.html.twig', [
            'registroForm' => $form->createView(),
        ]);
    }

   
}