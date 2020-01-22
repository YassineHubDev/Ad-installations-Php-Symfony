<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpecialiteController extends AbstractController
{
    /**
     * @Route("cuisines", name="app_cuisine")
     * @return Response
     */
    public function cuisine(): Response
    {
        return $this->render('speciality/cuisine.html.twig');
    }


    /**
     * @Route("salles-de-bain", name="app_sdb")
     * @return Response
     */
    public function sdb(): Response
    {
        return $this->render('speciality/sdb.html.twig');
    }


    /**
     * @Route("dressing", name="app_placard")
     * @return Response
     */
    public function placard(): Response
    {
        return $this->render('speciality/placard.html.twig');
    }
}