<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    /**
     * @Route("protection-des-donnees", name="app_rgpd")
     * @return Response
     */
    public function apropos(): Response
    {
        return $this->render('footerpages/rgpd.html.twig');
    }


    /**
     * @Route("mentions-legales", name="app_mentions")
     * @return Response
     */
    public function mentions(): Response
    {
        return $this->render('footerpages/mentions.html.twig');
    }


    /**
     * @Route("contacts", name="app_contacts")
     * @return Response
     */
    public function contacts(): Response
    {
        return $this->render('footerpages/contacts.html.twig');
    }
}