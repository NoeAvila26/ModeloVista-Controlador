<?php

namespace App\Controllers;

use App\Models\MensajeModel;

class Home extends BaseController
{
    public function index()
    {
        // Verificar que el usuario haya iniciado sesión
        if (!session()->get('autenticado')) {
            return redirect()->to(site_url('login'));
        }

        $modelo = new MensajeModel();

        $datos = $modelo->obtenerMensaje();

        // Obtener información del usuario autenticado
        $datos['usuario'] = session()->get('usuario_nombre');

        return view('inicio', $datos);
    }
}
