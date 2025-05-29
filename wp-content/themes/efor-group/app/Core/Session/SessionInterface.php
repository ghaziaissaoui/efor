<?php

namespace App\Core\Session;

interface SessionInterface
{
    /**
     * Récupère une info en session
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Ajoute une info en session
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void;

    /**
     * Supprime un clé en session
     * @param string $key
     */

    public function delete(string $key): void;
}
