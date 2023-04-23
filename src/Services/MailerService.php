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

    /**
     * Create an mailer service with a custom template
     *
     * @param string $to
     * @param string $subject
     * @param string $template
     * @param array $info
     * @return void
     */
    public function sendEmail(
                                string $to, 
                                string $subject, 
                                string $template, 
                                array $info ): void                 
    {
            $email = (new TemplatedEmail())
                ->to($to)
                ->subject($subject)
                ->htmlTemplate($template)
                ->context($info);
          
       $this->mailer->send($email);
    }
}