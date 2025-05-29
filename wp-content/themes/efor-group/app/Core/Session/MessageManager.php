<?php

namespace App\Core\Session;

class MessageManager
{
    /**
     * @var SessionInterface
     */
    private $session;

    private $session_key = "flash";

    private $messages = null;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function success($message)
    {
        $flash = $this->session->get($this->session_key, []);
        $flash['success'] = $message;
        $this->session->set($this->session_key, $flash);
    }

    public function error($message)
    {
        $flash = $this->session->get($this->session_key, []);
        $flash['danger'] = $message;
        $this->session->set($this->session_key, $flash);
    }

    public function warning($message)
    {
        $flash = $this->session->get($this->session_key, []);
        $flash['warning'] = $message;
        $this->session->set($this->session_key, $flash);
    }

    public function info($message)
    {
        $flash = $this->session->get($this->session_key, []);
        $flash['info'] = $message;
        $this->session->set($this->session_key, $flash);
    }

    public function hasFlashes()
    {
        if (is_null($this->messages)) {
            $this->messages = $this->session->get($this->session_key, []);
            $this->session->delete($this->session_key);
        }

        return !empty($this->messages);
    }

    public function get(string $type): ?string
    {
        if (is_null($this->messages)) {
            $this->messages = $this->session->get($this->session_key, []);
            $this->session->delete($this->session_key);
        }


        if (array_key_exists($type, $this->messages)) {
            return $this->messages[$type];
        }

        return null;
    }
}
