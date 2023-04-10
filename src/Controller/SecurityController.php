<?php

namespace App\Controller;

use App\Form\RequestPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/step1', name: 'app_step1')]
    public function step1(AuthenticationUtils $authenticationUtils): Response
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
      
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/step1.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }



    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/ask-password', name: 'app_askpassword', methods: ['GET','POST'])]
    public function askPassword(Request $request,
                                UserRepository $userRepository,
                                EntityManagerInterface $em,
                                TokenGeneratorInterface $tokenGenerator,
                                MailerService $mailer):Response
    {

        $form = $this->createForm(RequestPasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneByEmail($form->get('Email')->getData());
            
            if(!$user) {
                $this->addFlash('alert','Une erreur s\'est produite');
            }

            $token = $tokenGenerator->generateToken();
            $user->setToken($token);
            $em->persist($user);
            $em->flush();

            $url = $this->generateUrl('app_reset_password', ['token' => $token],UrlGeneratorInterface::ABSOLUTE_URL);

           $mailer->sendEmail('lequaiantique@hotmail.com',
                              $user->getEmail(),
                              'Demande de ré-initialisation du mot de passe',
                              'email/reset-password.html.twig',
                            ['url' => $url]);

             $this->addFlash('success', 'un email vous a été envoyé où se trouve votre lien de réinitialisation');
             return $this->redirectToRoute('app_login');
        }        
        

        return $this->render('security/requestPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/ask-password/{token}', name: 'app_reset_password', methods: ['GET','POST'])]
    public function resetPassword(string $token,
                                    UserRepository $userRepository,
                                    Request $request,
                                    UserPasswordHasherInterface $passwordHash,
                                    EntityManagerInterface $em):Response
    {

        $user = $userRepository->findOneByToken($token);

        
        if(!$user) {
            $this->addFlash('alert', 'Jeton non valide');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user->setToken('');
            $user->setPassword( $passwordHash->hashPassword($user, $form->get('password')->getData()));
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été enregistre');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/resetPassword.html.twig', [
            'form'=> $form->createView()
        ]);
    }
    
}
