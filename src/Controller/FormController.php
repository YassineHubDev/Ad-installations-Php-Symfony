<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Magasin;
use App\Form\ClientFormType;
use App\Form\MagFormType;
use App\Notification\FormNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FormController extends AbstractController
{
    /**
     * @Route("/votre-projet-particulier", name="app_form_client")
     *
     * @param User $user
     *
     * @return Response
     */
    public function formClient(Request $request, FormNotification $notification, TokenStorageInterface $tokenStorage): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $tokenStorage->getToken()->getUser();
            $client->setPublisher($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            $notification->notify2($client, $user);

            $this->addFlash(
                'notice',
                'Votre message a bien été envoyé ! L\'équipe AD-INSTALLATIONS vous répondra dans les plus brefs délais.'
            );

            return $this->redirectToRoute('app_home');

            // do anything else you need here, like send an email
        }

        return $this->render('form/formclient.html.twig', [
            'clientForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/votre-projet-magasin", name="app_form_magasin")
     *
     * @param User $user
     *
     * @return Response
     */
    public function formMag(Request $request, TokenStorageInterface $tokenStorage, FormNotification $notification): Response
    {
        $magasin = new Magasin();
        $form = $this->createForm(MagFormType::class, $magasin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $tokenStorage->getToken()->getUser();
            $magasin->setPublisher($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($magasin);
            $entityManager->flush();

            $notification->notify1($magasin, $user);

            $this->addFlash(
                'notice',
                'Votre message a bien été envoyé ! L\'équipe AD-INSTALLATIONS vous répondra dans les plus brefs délais.'
            );

            return $this->redirectToRoute('app_home');

            // do anything else you need here, like send an email
        }

        return $this->render('form/formmag.html.twig', [
            'magForm' => $form->createView(),
        ]);
    }
}
