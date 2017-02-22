<?php

namespace Pmc\Session\Storage;

/**
 * @author Gargoyle <g@rgoyle.com>
 */
class BasicStorage implements StorageProvider
{
    private $storageKey = 'Pmc\Session\Storage\BasicStorage';
    
    public function load(): array
    {
        if (isset($_SESSION[$this->storageKey])) {
            return $_SESSION[$this->storageKey];
        }
    }

    public function save(array $sessionData): void
    {
        if (isset($_SESSION)) {
            $_SESION[$this->storageKey] = $sessionData;
        }
    }
}
