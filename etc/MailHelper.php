<?php

namespace Framework;

use DI\Container;
use Framework\Interfaces\RenderInterfaces;
class MailHelper
{
    /**
     * @var $mail
     */
    private $mail;

    /**
     * @var $sendgridApiKey
     */
    private $sendgridApiKey;

    /**
     * MailHelper constructor.
     * @param string $sendgridApiKey
     */
    public function __construct(string $sendgridApiKey) {

        $this->sendgridApiKey = $sendgridApiKey;
    }

    /**
     * @param string $subject
     * @param array $from
     * @param array $to
     */
    private function builtMail(string $subject, array $from, array $to) {

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($from['email'],$from['name']);
        $email->setSubject($subject);
        $email->addTo($to['email'], $to['name']);
        $email->addContent(
            "text/html", $this->render->render()
        );

    }

   public function sendMail(string $subject, array $from, array $to) {

        $mail = $this->builtMail($subject, $from, $to);
    }
}