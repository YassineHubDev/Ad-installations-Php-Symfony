<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    
    /**
     * @Route("/home")
     */
    public function redictAction()
    {
        $authChecker = $this->container-get ('security.authorization_checker');
        
        if($authChecker->isGranted('ROLE_CLIENT')) {
            return $this->render('form/formclient/html.twig');
        } else if ($authChecker->isGranted('ROLE_MAGASIN')) {
            return $this->render('form/formmag/html.twig');
        } else {
            return $this->render('security/login/html.twig');
        }
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
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, TokenAuthenticator $tokenAuthenticator): Response
    {

        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
            /* @var $user User */

            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('app_home');
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

            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('y.aabidouche@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "blablabla voici le token pour reseter votre mot de passe : " . $url,
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('notice', 'E-mail envoyé');

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

            $this->addFlash('notice', 'Mot de passe mis à jour');

            return $this->redirectToRoute('app_home');
        }else {

            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }

    }

}