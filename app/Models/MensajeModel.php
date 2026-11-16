<?php

namespace App\Models;

class MensajeModel
{
    public function obtenerMensaje(): array
    {
        return [
            'titulo' => 'Mi primera aplicación MVC',
            'mensaje' => 'Información obtenida desde el modelo'
        ];
    }
}