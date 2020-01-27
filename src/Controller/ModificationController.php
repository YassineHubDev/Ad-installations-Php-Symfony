<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModificationController extends AbstractController
{
    /**
     * @Route("/votre-profil", name="app_profile")
     */
    public function profileEdit(Request $request, ObjectManager $manager): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $request->request->get('account', []);
            if (array_key_exists('roles', $datas)) {
                $user->setRoles([$datas['roles']]);
            }

            //dump($form->getData());exit;
            //            if ($user->getAvatar() !== null) {
            //                $file = $user->getAvatar();
            //                $user->setAvatarFile($file);
            //            }

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Les modifications ont bien été prises en compte.'
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('profil/mon-profil.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //
    //
    //    /**
    //     * @Route("/modif-mot-de-passe", name="app_reset_password_connected")
    //     * @return \Symfony\Component\HttpFoundation\Response
    //     */
    //    public function resetPasswordConnected(Request $request)
    //    {
    //    	$em = $this->getDoctrine()->getManager();
    //        $user = $this->getUser();
    //    	$form = $this->createForm(ResetMdpType::class, $user);
    //
    //    	$form->handleRequest($request);
    //        if ($form->isSubmitted() && $form->isValid()) {
    //
    //            $passwordEncoder = $this->get('security.user_password_encoder.generic');
    //            $oldPassword = $request->request->get('reset_password')['oldPassword'];
    //
    //            // Si l'ancien mot de passe est bon
    //            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
    //                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
    //                $user->setPassword($newEncodedPassword);
    //
    //                $em->persist($user);
    //                $em->flush();
    //
    //                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');
    //
    //                return $this->redirectToRoute('app_home');
    //            } else {
    //                $form->addError(new FormError('Ancien mot de passe incorrect'));
    //            }
    //        }
    //
    //    	return $this->render('security/modif-mot-de-passe.html.twig', array(
    //    		'form' => $form->createView(),
    //    	));
    //    }
}
