<?php

declare(strict_types=1);

class Example
{
    public function hola(): array
    {
        $saludo = 'hola como estas';
        $persona = 'Juan';

        return ['saludo' => $saludo, 'persona' => $persona];
    }
}
