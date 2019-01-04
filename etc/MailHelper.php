<?php

namespace Framework;

use Framework\Interfaces\RenderInterfaces;
class MailHelper
{
    /**
     * @var $sendgridApiKey
     */
    private $sendgridApiKey;

    /**
     * @var RenderInterfaces
     */
    private $render;

    /**
     * MailHelper constructor.
     * @param string $sendgridApiKey
     */
    public function __construct(string $sendgridApiKey, RenderInterfaces $render) {

        $this->sendgridApiKey = $sendgridApiKey;
        $this->render = $render;
    }

    /**
     * @param string $subject
     * @param array $from
     * @param array $to
     */
    private function builtMail(string $subject, array $from, array $to, string $template) {

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($from['email'],$from['name']);
        $email->setSubject($subject);
        $email->addTo($to['email'], $to['name']);
        $email->addContent(
            "text/html", $this->render->render($template)
        );

        return $email;

    }

    /**
     * @param string $subject
     * @param array $from
     * @param array $to
     * @param string $template
     */
    public function sendMail(string $subject, array $from, array $to, string $template) {

        $mail = $this->builtMail($subject, $from, $to, $template);
        $this->getSendGrid()->send($mail);
    }

    /**
     * @return \SendGrid
     */
    private function getSendGrid() {

        return new \SendGrid($this->sendgridApiKey);
    }
}