<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


class MailerService
{
  
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail( string $from, 
                                string $to, 
                                string $subject, 
                                string $template, 
                                array $info ): void                 
    {
     

            $email = (new TemplatedEmail())
                ->from($from)
                ->to($to)
                ->subject($subject)
                ->htmlTemplate($template)
                ->context($info);
          
       $this->mailer->send($email);
    }
}