<?php

namespace Framework;

use Framework\Interfaces\RenderInterfaces;

class MailHelper
{
    /**
     * @var $sendgridApiKey
     */
    private $sendGridApiKey;

    /**
     * @var RenderInterfaces
     */
    private $render;

    /**
     * MailHelper constructor.
     *
     * @param string $sendgridApiKey
     * @param RenderInterfaces $render
     */
    public function __construct(string $sendGridApiKey, RenderInterfaces $render) {

        $this->sendgridApiKey = $sendGridApiKey;
        $this->render = $render;
    }

    /**
     * @param string $subject
     * @param array $from
     * @param array $to
     * @param string $template
     *
     * @return \SendGrid\Mail\Mail
     *
     * @throws \SendGrid\Mail\TypeException
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
     *
     * @throws \SendGrid\Mail\TypeException
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