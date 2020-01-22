<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use App\Form\RegistrationMagType;
use App\Security\AppAuthenticator;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class AuthController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * @Route("/inscription", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param AppAuthenticator $authenticator
     * @return Response
     */
    public function register(Request $request, 
                             ContactNotification $notification, 
                             UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $datas = $request->request->get('registration_form', []);
            if (array_key_exists('roles', $datas)) {
                $user->setRoles([$datas['roles']]);
            }
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setConfirmationToken(bin2hex(random_bytes(60)));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $notification->notify($user);

            $this->addFlash(
                'notice',
                'Un e-mail de confirmation vient de vous être envoyé.'
            );

            return $this->redirectToRoute('app_home');


            // do anything else you need here, like send an email

        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activate-user/{email}", name="app_activate_user")
     * @param Request $request
     * @return Response
     */
    public function activateUser(User $user, 
                                 Request $request, 
                                 UserRepository $userRepository, 
                                 GuardAuthenticatorHandler $guardHandler, 
                                 AppAuthenticator $authenticator) 
    {
        $isValidConfirmationToken = $userRepository->isValidConfirmationToken($request->query->get('confirmationToken'), $user->getEmail());

        $lastUsername = $user->getUsername();

        if ($isValidConfirmationToken) {
            $user->setActive(true);
            $user->setConfirmationToken(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Félicitations ! Votre compte est maintenant activé.');
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        } else {
            $this->addFlash('warning', 'Token invalid'); 
        }

        return $this->redirectToRoute('app_home');

    }
}