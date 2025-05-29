<?php

namespace App\Core\Session;

class PHPSession implements SessionInterface
{
    /**
     * Récupère une info en session
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $this->sessionStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        return $default;
    }

    /**
     * Assure que la session est démarrée
     */
    private function sessionStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Ajoute une info en session
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        $this->sessionStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Supprime un clé en session
     * @param string $key
     */
    public function delete(string $key): void
    {
        $this->sessionStarted();
        unset($_SESSION[$key]);
    }
}
