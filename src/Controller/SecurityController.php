<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;



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

}