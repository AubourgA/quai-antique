<?php

namespace App\Services;

use DateTime;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;



class MailerService
{
  
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail( string $to, string $subject, $info ): void                 
    {
     

            $email = (new TemplatedEmail())
                ->from('lequaiantique@hotmail.com')
                ->to($to)
                ->subject($subject)
                ->htmlTemplate('email/confirm.html.twig')
                ->context( [
                    'date' => $info->getDate(),
                    'time' => $info->getTime(),
                    'nb' => $info->getNumberPerson()
                 ]);
          
       $this->mailer->send($email);
    }
}