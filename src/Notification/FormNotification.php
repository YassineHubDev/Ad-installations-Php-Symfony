<?php

namespace App\Notification;

use App\Entity\Client;
use App\Entity\Magasin;
use App\Entity\User;
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
        $appUrl = $this->parameters->get('app.url');
        $message = (new \Swift_Message('Devis : ' . $client->getSujet()))
            ->setSubject('Demande de devis')
            ->setFrom($this->parameters->get('app.email.noreply'))
            ->setTo('futurdev@protonmail.com')
            ->setBody(
                $this->renderer->render('email/modele-form-client.html.twig', [
                    'client' => $client,
                    'appUrl' => $appUrl
                ]), 'text/html'
        );
        // Envoi du mail
        $this->mailer->send($message);
//        return $this->render('email/index.html.twig', [
//            'controller_name' => 'EmailController',
//        ]);
    }
    
    
    public function notify1 (Magasin $magasin) 
    {
        $appUrl = $this->parameters->get('app.url');
        $message = (new \Swift_Message('Devis : ' . $magasin->getSujet()))
            ->setSubject('Demande de devis')
            ->setFrom($this->parameters->get('app.email.noreply'))
            ->setTo('futurdev@protonmail.com')
            ->setBody(
                $this->renderer->render('email/modele-form-mag.html.twig', [
                    'magasin' => $magasin,
                    'appUrl' => $appUrl
                ]), 'text/html'
        );
        // Envoi du mail
        $this->mailer->send($message);
//        return $this->render('email/index.html.twig', [
//            'controller_name' => 'EmailController',
//        ]);
    }
    
    
    
    public function notify3 (user $user) 
    {
        $appUrl = $this->parameters->get('app.url');
        $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('test.doranco2020@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderer->render('email/mail-mdp.html.twig', [
                        'user' => $user,
                        'appUrl' => $appUrl
                ]),     'text/html'
                );
        // Envoi du mail
        $this->mailer->send($message);
//        return $this->render('email/index.html.twig', [
//            'controller_name' => 'EmailController',
//        ]);
    }
    
    
}
