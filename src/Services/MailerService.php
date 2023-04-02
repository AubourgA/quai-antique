<?php

namespace App\Services;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


class MailerService
{
  
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail( string $to, string $subject, string $text ): void                 
    {
        $email = (new Email())
            ->from('lequaiantique@hotmail.com')
            ->to($to)
            ->subject($subject)
            ->text($text);
          
       $this->mailer->send($email);
    }
}