<?php

namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotif
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {

        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Agences : itMatch'))
            ->setFrom($contact->getEmail())
            ->setTo('mohamedali.boubtane@viacesi.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('home/emails.html.twig',[
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);

    }
}