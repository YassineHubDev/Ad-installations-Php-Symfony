<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SwiftMailerController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(\Swift_Mailer $mailer)
    {
        // Création du mail
        $mail = new \Swift_Message();
        $mail->setSubject('Envoi de mail depuis AD-INSTALLATIONS');
        $mail->setFrom('y.aabidouche@gmail.com');
        $mail->setTo('y.aabidouche@gmail.com');
        $mail->setBody(
            $this->renderView('email/modele-mail.html.twig'),
            'text/html'
        );
        // Envoi du mail
        $mailer->send($mail);
        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}