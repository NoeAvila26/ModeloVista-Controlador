<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
    public function index(): string
    {
        // Crear una instancia del modelo
        $modelo = new UsuarioModel();

        // Obtener los usuarios registrados
        $usuarios = $modelo->obtenerUsuarios();

        // Enviar los datos a la vista
        return view('usuarios/index', [
            'usuarios' => $usuarios
        ]);
    }

      // Mostrar formulario de creación
    public function crear(): string
    {
        return view('usuarios/crear');
    }


    // Guardar un nuevo usuario
    public function guardar()
    {
        // Obtener los datos del formulario
        $nombre = trim($this->request->getPost('nombre') ?? '');
        $email = strtolower(trim($this->request->getPost('email') ?? ''));
        $password = $this->request->getPost('password') ?? '';
        $birthday = $this->request->getPost('birthday') ?? '';
        $languages = $this->request->getPost('languages') ?? [];

        // Validar los campos
        if (
            $nombre === '' ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            $password === '' ||
            $birthday === '' ||
            !is_array($languages) ||
            empty($languages)
        ) {
            return redirect()->back()
                ->with('mensaje', 'Por favor, completa todos los campos.');
        }

        // Validar los lenguajes seleccionados
        $permitidos = ['JavaScript', 'Python', 'PHP', 'Java'];

        if (
            array_diff($languages, $permitidos) ||
            count($languages) !== count(array_unique($languages))
        ) {
            return redirect()->back()
                ->with('mensaje', 'Selecciona lenguajes válidos.');
        }

        // Consultar los usuarios existentes
        $modelo = new UsuarioModel();
        $usuarios = $modelo->obtenerUsuarios();

        // Comprobar si el correo ya existe
        foreach ($usuarios as $usuario) {
            if (strtolower($usuario['email']) === $email) {
                return redirect()->back()
                    ->with('mensaje', 'Este correo ya está registrado.');
            }
        }

        // Preparar los datos del nuevo usuario
        $datos = [
            'nombre' => $nombre,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'birthday' => $birthday,
            'languages' => $languages
        ];

        // Guardar el usuario
        if ($modelo->crearUsuario($datos)) {
            return redirect()->to(site_url('usuarios'))
                ->with('mensaje', '¡Usuario registrado correctamente!');
        }

        return redirect()->back()
            ->with('mensaje', 'Ocurrió un error al guardar el usuario.');
    }


    // Mostrar formulario de edición
    public function editar(string $id)
    {
        $modelo = new UsuarioModel();

        // Buscar el usuario seleccionado
        $usuario = $modelo->obtenerUsuarioPorId($id);

        // Comprobar que exista
        if ($usuario === null) {
            return redirect()->to(site_url('usuarios'))
                ->with('mensaje', 'El usuario no existe.');
        }

        // Mostrar formulario con sus datos
        return view('usuarios/editar', [
            'usuario' => $usuario
        ]);
    }

    // Procesar la actualización de un usuario
public function actualizar(string $id)
{
    $modelo = new UsuarioModel();

    // Buscar al usuario actual
    $usuarioActual = $modelo->obtenerUsuarioPorId($id);

    if ($usuarioActual === null) {
        return redirect()->to(site_url('usuarios'))
            ->with('mensaje', 'El usuario no existe.');
    }

    // Obtener los datos del formulario
    $nombre = trim($this->request->getPost('nombre') ?? '');
    $email = strtolower(trim($this->request->getPost('email') ?? ''));
    $password = $this->request->getPost('password') ?? '';
    $birthday = $this->request->getPost('birthday') ?? '';
    $languages = $this->request->getPost('languages') ?? [];

    // Validar los campos
    if (
        $nombre === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        $birthday === '' ||
        !is_array($languages) ||
        empty($languages)
    ) {
        return redirect()->back()
            ->with('mensaje', 'Por favor, completa todos los campos.');
    }

    // Validar los lenguajes permitidos
    $permitidos = ['JavaScript', 'Python', 'PHP', 'Java'];

    if (
        array_diff($languages, $permitidos) ||
        count($languages) !== count(array_unique($languages))
    ) {
        return redirect()->back()
            ->with('mensaje', 'Selecciona lenguajes válidos.');
    }

    // Comprobar que el correo no pertenezca a otro usuario
    $usuarios = $modelo->obtenerUsuarios();

    foreach ($usuarios as $otroUsuario) {
        if (
            $otroUsuario['id'] !== $id &&
            strtolower($otroUsuario['email']) === $email
        ) {
            return redirect()->back()
                ->with('mensaje', 'Este correo ya está registrado.');
        }
    }

    // Preparar los datos actualizados
    $datos = [
        'nombre' => $nombre,
        'email' => $email,
        'password' => $password !== ''
            ? password_hash($password, PASSWORD_DEFAULT)
            : $usuarioActual['password'],
        'birthday' => $birthday,
        'languages' => $languages
    ];

    // Guardar los cambios
    if ($modelo->actualizarUsuario($id, $datos)) {
        return redirect()->to(site_url('usuarios'))
            ->with('mensaje', '¡Usuario actualizado correctamente!');
    }

    return redirect()->back()
        ->with('mensaje', 'Ocurrió un error al actualizar el usuario.');
}

// Procesar la eliminación de un usuario
public function eliminar(string $id)
{
    $modelo = new UsuarioModel();

    if ($modelo->eliminarUsuario($id)) {
        return redirect()->to(site_url('usuarios'))
            ->with('mensaje', '¡Usuario eliminado correctamente!');
    }

    return redirect()->to(site_url('usuarios'))
        ->with('mensaje', 'No se encontró el usuario que deseas eliminar.');
}


}
