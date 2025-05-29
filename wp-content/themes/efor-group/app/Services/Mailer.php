<?php

namespace App\Services;

use App\Core\Interfaces\MailInterface;

class Mailer implements MailInterface
{
    protected string $subject;

    protected string $to;

    protected string $from;

    protected string $from_name;

    protected array $content = [];
    /**
     * @var string
     */
    private string $message;

    /**
     * Initialise l'email
     *
     * @param string $to
     * @param string $subject
     * @param string $from_name
     * @param string $from
     *
     * @return MailInterface
     */
    public function init(
        string $to,
        string $subject,
        string $from_name = '',
        string $from = ''
    ): MailInterface {
        $this->from      = ! empty($from) ? $from : get_bloginfo('admin_email');
        $this->from_name = ! empty($from_name) ? $from_name : get_bloginfo('name');
        $this->subject   = $subject;
        $this->to        = $to;

        return $this;
    }


    /**
     * Envoie le mail final
     *
     */
    public function send(): bool
    {
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $this->from_name . ' <' . $this->from . '>'
        );

        return wp_mail($this->to, $this->subject, $this->message, $headers);
    }

    public function setBody(string $content): MailInterface
    {
        $this->message = $content;
        return $this;
    }
}
