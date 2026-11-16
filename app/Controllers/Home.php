<?php

namespace App\Controllers;

use App\Models\MensajeModel;

class Home extends BaseController
{
    public function index(): string
    {
        $modelo = new MensajeModel();

        $datos = $modelo->obtenerMensaje();

        return view('inicio', $datos);
    }
}