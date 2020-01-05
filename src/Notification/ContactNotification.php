<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class ContactNotification {
    
    /**
     *@var \Swift_Mailer
     */
    private $mailer;
    
    
    /**
     *@var Environment
     */
    private $renderer;
    
    
    public function __construct(\Swift_Mailer $mailer, Environment $renderer,
        TokenGeneratorInterface $tokenGenerator)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer; 
    }
    
    public function notify (User $user) {
        $message = (new \Swift_Message('Confirmation : ' . $user->getUsername()))
            ->setSubject('Envoi de mail TEST AD-INSTALLATIONS')
            ->setFrom('y.aabidouche@gmail.com')
            ->setTo('y.aabidouche@gmail.com')
            ->setBody(
                $this->renderer->render('email/modele-mail.html.twig', [
                    'user' => $user
                ]), 'text/html'
        );
        // Envoi du mail
        $this->mailer->send($message);
//        return $this->render('email/index.html.twig', [
//            'controller_name' => 'EmailController',
//        ]);
    }
}




























