<?php

namespace App\Models;

class ArchivoModel
{
    private string $rutaDatos;

    public function __construct()
    {
        $this->rutaDatos = WRITEPATH . 'datos/archivos.json';

        if (!is_dir(dirname($this->rutaDatos))) {
            mkdir(dirname($this->rutaDatos), 0755, true);
        }

        if (!file_exists($this->rutaDatos)) {
            file_put_contents($this->rutaDatos, json_encode([]));
        }
    }

    // Obtener todos los archivos registrados
    public function obtenerArchivos(): array
    {
        $contenido = file_get_contents($this->rutaDatos);

        return json_decode($contenido, true) ?? [];
    }

    // Guardar un nuevo registro
    public function guardarArchivo(array $archivo): bool
    {
        $archivos = $this->obtenerArchivos();

        $archivos[] = $archivo;

        return file_put_contents(
            $this->rutaDatos,
            json_encode($archivos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        ) !== false;
    }

    // Eliminar un registro por identificador
    public function eliminarArchivo(string $id): bool
    {
        $archivos = $this->obtenerArchivos();

        $archivos = array_filter(
            $archivos,
            fn($archivo) => $archivo['id'] !== $id
        );

        return file_put_contents(
            $this->rutaDatos,
            json_encode(array_values($archivos), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        ) !== false;
    }
}
