<?php

namespace App\Notification;

use App\Entity\Client;
use App\Entity\Magasin;
use App\Entity\User;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Environment;

class FormNotification
{
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

    public function notify2(Client $client, User $user)
    {
        $appUrl = $this->parameters->get('app.url');
        $message = (new \Swift_Message('Devis : '.$client->getSujet()))
            ->setSubject('AD-INSTALLATIONS : Nouveau projet')
            ->setFrom($this->parameters->get('app.email.noreply'))
            ->setTo('ad.installations77@gmail.com');

        $img = $message->embed(\Swift_Image::fromPath('img/upload/logo/logo_ad-installations.png'));
        $message->setBody(
            $this->renderer->render('email/modele-form-client.html.twig', [
                'client' => $client,
                'user' => $user,
                'appUrl' => $appUrl,
                'img' => $img,
            ]), 'text/html'
        );

        // Envoi du mail
        $this->mailer->send($message);
        //        return $this->render('email/index.html.twig', [
        //            'controller_name' => 'EmailController',
        //        ]);
    }

    public function notify1(Magasin $magasin, User $user)
    {
        $appUrl = $this->parameters->get('app.url');
        $message = (new \Swift_Message('Devis : '.$magasin->getSujet()))
            ->setSubject('AD-INSTALLATIONS : Nouveau projet')
            ->setFrom($this->parameters->get('app.email.noreply'))
            ->setTo('ad.installations77@gmail.com');

        $img = $message->embed(\Swift_Image::fromPath('img/upload/logo/logo_ad-installations.png'));
        $message->setBody(
            $this->renderer->render('email/modele-form-mag.html.twig', [
                'magasin' => $magasin,
                'user' => $user,
                'appUrl' => $appUrl,
                'img' => $img,
            ]), 'text/html'
        );
        // Envoi du mail
        $this->mailer->send($message);
        //        return $this->render('email/index.html.twig', [
        //            'controller_name' => 'EmailController',
        //        ]);
    }

    public function notify3(user $user)
    {
        $appUrl = $this->parameters->get('app.url');
        $message = (new \Swift_Message('Mot de passe oublié'))
            ->setFrom('contact@ad-installations.fr')
            ->setTo($user->getEmail());

        $img = $message->embed(\Swift_Image::fromPath('img/upload/logo/logo_ad-installations.png'));
        $message->setBody(
            $this->renderer->render('email/mail-mdp.html.twig', [
                'user' => $user,
                'appUrl' => $appUrl,
                'img' => $img,
            ]), 'text/html'
        );
        // Envoi du mail
        $this->mailer->send($message);
        //        return $this->render('email/index.html.twig', [
        //            'controller_name' => 'EmailController',
        //        ]);
    }
}
