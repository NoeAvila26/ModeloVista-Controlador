<?php

namespace App\Models;

class UsuarioModel
{
    private string $archivo;

    public function __construct()
    {
        $this->archivo = WRITEPATH . 'datos/usuarios.json';
    }

    // Obtener todos los usuarios
    public function obtenerUsuarios(): array
    {
        $contenido = file_get_contents($this->archivo);

        $usuarios = json_decode($contenido, true);

        return is_array($usuarios) ? $usuarios : [];
    }

    // Buscar un usuario por su correo electrónico
    public function obtenerUsuarioPorEmail(string $email): ?array
    {
    $usuarios = $this->obtenerUsuarios();

    foreach ($usuarios as $usuario) {

        if (
            isset($usuario['email']) &&
            strtolower($usuario['email']) === strtolower($email)
        ) {
            return $usuario;
        }
    }

    return null;
   }


    // Registrar un nuevo usuario
    public function crearUsuario(array $datos): bool
    {
        $usuarios = $this->obtenerUsuarios();

        // Asignar un identificador único
        $datos['id'] = uniqid();

        // Agregar el nuevo usuario
        $usuarios[] = $datos;

        // Guardar los cambios en JSON
        $json = json_encode(
            $usuarios,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return file_put_contents($this->archivo, $json, LOCK_EX) !== false;
    }


    // Buscar un usuario por su identificador
    public function obtenerUsuarioPorId(string $id): ?array
    {
        $usuarios = $this->obtenerUsuarios();

        foreach ($usuarios as $usuario) {

            if ($usuario['id'] === $id) {
                return $usuario;
            }
        }

        return null;
    }

    // Actualizar los datos de un usuario
public function actualizarUsuario(string $id, array $datos): bool
{
    $usuarios = $this->obtenerUsuarios();

    foreach ($usuarios as $indice => $usuario) {

        if ($usuario['id'] === $id) {

            // Conservar el identificador original
            $datos['id'] = $id;

            // Reemplazar los datos del usuario
            $usuarios[$indice] = $datos;

            // Guardar los cambios en JSON
            $json = json_encode(
                $usuarios,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            );

            return file_put_contents($this->archivo, $json, LOCK_EX) !== false;
        }
    }

    return false;
}

// Eliminar un usuario por su identificador
public function eliminarUsuario(string $id): bool
{
    $usuarios = $this->obtenerUsuarios();

    $usuariosActualizados = [];

    foreach ($usuarios as $usuario) {

        if ($usuario['id'] !== $id) {
            $usuariosActualizados[] = $usuario;
        }
    }

    // Si no se encontró el usuario, no realizar cambios
    if (count($usuarios) === count($usuariosActualizados)) {
        return false;
    }

    // Guardar el listado actualizado
    $json = json_encode(
        $usuariosActualizados,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    return file_put_contents($this->archivo, $json, LOCK_EX) !== false;
}


}
