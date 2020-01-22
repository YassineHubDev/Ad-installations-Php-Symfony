<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ContactNotification {

    /**
     *@var \Swift_Mailer
     */
    private $mailer;

    /**
     *@var Environment
     */
    private $renderer;

    /**
     *@var ParameterBagInterface
     */
    private $parameters;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer, ParameterBagInterface $parameters)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
        $this->parameters = $parameters;
    } 

    public function notify (User $user) 
    {
        $appUrl = $this->parameters->get('app.url');
        $message = (new \Swift_Message('Confirmation : ' . $user->getUsername()))
            ->setSubject('Confirmation de votre compte')
            ->setFrom($this->parameters->get('app.email.noreply'))
            ->setTo($user->getEmail());

        $img = $message->embed(\Swift_Image::fromPath('img/upload/logo/logo_ad-installations.png'));
        $message->setBody(
            $this->renderer->render('email/modele-mail.html.twig', [
                'user' => $user,
                'appUrl' => $appUrl,
                'img'    => $img,
            ]), 'text/html'
        );
        // Envoi du mail
        $this->mailer->send($message);
        //        return $this->render('email/index.html.twig', [
        //            'controller_name' => 'EmailController',
        //        ]);
    }
}