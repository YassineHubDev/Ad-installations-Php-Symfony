<?php

namespace App\Notification;

use App\Entity\Client;
use App\Entity\Magasin;
use Twig\Environment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FormNotification {
    
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
    
    public function notify2 (Client $client) 
    {
        $message = (new \Swift_Message('Devis : ' . $client->getSujet()))
            ->setSubject('Demande de devis')
            ->setFrom($this->parameters->get('app.email.noreply'))
            ->setTo('futurdev@protonmail.com')
            ->setBody(
                $this->renderer->render('email/modele-form.html.twig', [
                    'client' => $client,
                ]), 'text/html'
        );
        // Envoi du mail
        $this->mailer->send($message);
//        return $this->render('email/index.html.twig', [
//            'controller_name' => 'EmailController',
//        ]);
    }
}
