<?php


namespace App\Controller;


use App\Entity\Client;
use App\Entity\Magasin;
use App\Form\ClientFormType;
use App\Form\MagFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class FormController extends AbstractController
{
    /**
     * @Route("/form-client", name="app_form_client")
     * @param Request $request
     * @param UserInterface $user
     * @return Response
     */
    public function formClient(Request $request, UserInterface $user): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        

            $client->setPublisher($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
            
            $this->addFlash(
                'notice',
                'Votre formulaire a bien été envoyé !'
            );
            return $this->redirectToRoute('app_home');
            
            // do anything else you need here, like send an email
        }

        return $this->render('form/formclient.html.twig', [
            'clientForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/form-magasin", name="app_form_magasin")
     * @param Request $request
     * @param UserInterface $user
     * @return Response
     */
    public function formMag(Request $request, UserInterface $user): Response
    {

        $magasin = new Magasin();
        $form = $this->createForm(MagFormType::class, $magasin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $magasin->setPublisher($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($magasin);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Votre formulaire a bien été envoyé ! '
            );
            return $this->redirectToRoute('app_home');

            // do anything else you need here, like send an email

        }

        return $this->render('form/formmag.html.twig', [
            'magForm' => $form->createView(),
        ]);
    }


}