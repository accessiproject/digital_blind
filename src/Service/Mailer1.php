<?php

namespace App\Service;

use Swift_Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;

class Mailer1
{
    public function send($form, $to, $subject, $body)
    {
            $message = (new \Swift_Message($subject))
                ->setFrom($form)
                ->setTo($to)
                ->setBody($body);
            $this->mailer->send($message);
    }
}
