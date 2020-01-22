<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetMdpType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\FormError;
use App\Notification\FormNotification;
use App\Security\TokenAuthenticator;


class SecurityController extends AbstractController
{
    /**
     * @Route("/logout", name="app_logout")
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception('');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        $user = $this->security->getUser();
        $roles = $user->getRoles();

        if (in_array('ROLE_CLIENT', $roles)) {
            return new RedirectResponse($this->urlGenerator->generate('app_form_client'));
        } elseif (in_array('ROLE_MAGASIN', $roles)) {
            return new RedirectResponse($this->urlGenerator->generate('app_form_magasin'));
        } else {
            throw new \Exception('Tu n\'est ni un client ni un magasin, qui es-tu donc ?');
        }
    }

    /**
      * @Route("/forgotten_password", name="app_forgotten_password")
      */
    public function forgottenPassword(
        Request $request, 
        UserPasswordEncoderInterface $encoder, 
        \Swift_Mailer $mailer, 
        TokenGeneratorInterface $tokenGenerator,
        FormNotification $notification
    ): Response
    {

        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Veuillez saisir l\'adresse email renseignée lors de votre inscription.');
                return $this->redirectToRoute('app_forgotten_password');
            }
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_home');
            }

            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $notification->notify3($user);


            $this->addFlash('notice', 'Un mail vous a été envoyé pour la modification de votre mot de passe.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/forgotten_password.html.twig');
    }




    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('app_home');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('notice', 'Votre mot de passe a été mis à jour.');

            return $this->redirectToRoute('app_home');
        }else {

            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }

    }

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/modification-du-mot-de-passe", name="app_reset_password_connected")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resetPasswordConnected(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ResetMdpType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            $passwordEncoder = $this->get('security.password_encoder');
            $oldPassword = $request->request->get('reset_password')['oldPassword'];


            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($newEncodedPassword);

                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('app_home');
            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('security/modif-mot-de-passe.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}