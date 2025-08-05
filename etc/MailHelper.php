<?php

namespace Framework;

use Framework\Interfaces\RenderInterfaces;
use SendGrid\Mail\Mail;

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
     * @param string           $sendgridApiKey
     * @param RenderInterfaces $render
     */
    public function __construct(
        string $sendGridApiKey,
        RenderInterfaces $render
    ) {
        $this->sendgridApiKey = $sendGridApiKey;
        $this->render = $render;
    }

    /**
     * @param string $subject
     * @param array  $from
     * @param array  $to
     * @param string $template
     *
     * @return \SendGrid\Mail\Mail
     *
     * @throws \SendGrid\Mail\TypeException
     */
    private function builtMail(
        string $subject,
        array $from,
        array $to,
        string $template,
        array $paramsTemplate = []
    ) {
        $email = new Mail();
        $email->setFrom($from['email'], $from['name']);
        $email->setSubject($subject);
        $email->addTo($to['email'], $to['name']);
        $email->addContent(
            "text/html",
            $this->render->render($template, $paramsTemplate)
        );

        return $email;
    }

    /**
     * @param string $subject
     * @param array  $from
     * @param array  $to
     * @param string $template
     *
     * @return \SendGrid\Response
     *
     * @throws \SendGrid\Mail\TypeException
     */
    public function sendMail(
        string $subject,
        array $from,
        array $to,
        string $template,
        array $paramsTemplate = []
    ) {
        $mail = $this->builtMail($subject, $from, $to, $template, $paramsTemplate);

        try {
            return $this->getSendGrid()->send($mail);
        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
            exit;
        }
    }

    /**
     * @return \SendGrid
     */
    private function getSendGrid()
    {
        return new \SendGrid($this->sendgridApiKey);
    }
}
