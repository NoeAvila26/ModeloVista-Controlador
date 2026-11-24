<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    // Mostrar formulario de inicio de sesión
    public function login()
    {
        helper('cookie');

        return view('auth/login', [
            'correoRecordado' => get_cookie('correo_recordado') ?? ''
        ]);
    }

    // Validar las credenciales del usuario
    public function autenticar()
    {
        $email = strtolower(trim($this->request->getPost('email')));
        $password = $this->request->getPost('password');

        $recordar = $this->request->getPost('recordar');

        $modelo = new UsuarioModel();
        $usuarios = $modelo->obtenerUsuarios();

        foreach ($usuarios as $usuario) {

            if (
                strtolower($usuario['email']) === $email &&
                password_verify($password, $usuario['password'])
            ) {

                // Crear sesión
                $sesion = session();
                $sesion->regenerate(true);

                $sesion->set([
                    'usuario_id' => $usuario['id'],
                    'usuario_nombre' => $usuario['nombre'],
                    'usuario_email' => $usuario['email'],
                    'usuario_rol' => $usuario['rol'],
                    'autenticado' => true
                ]);

                // Recordar correo mediante una cookie
                helper('cookie');

                if ($recordar) {
                    set_cookie(
                        'correo_recordado',
                        $email,
                        60 * 60 * 24 * 30
                    );
                } else {
                    delete_cookie('correo_recordado');
                }

                return redirect()->to(site_url('usuarios'));
            }
        }

        return redirect()->back()
            ->with('error', 'Correo o contraseña incorrectos.');
    }

    // Cerrar sesión
    public function salir()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}

