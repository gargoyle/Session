<?php

namespace Pmc\Session\Storage;

/**
 * @author Gargoyle <g@rgoyle.com>
 */
interface StorageProvider
{
    public function save(array $sessionData): void;
    public function load(): array;
}
