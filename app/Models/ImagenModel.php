<?php

namespace App\Models;

class ImagenModel
{
    private string $rutaDatos;

    public function __construct()
    {
        $this->rutaDatos = WRITEPATH . 'datos/imagenes.json';

        if (!is_dir(dirname($this->rutaDatos))) {
            mkdir(dirname($this->rutaDatos), 0755, true);
        }

        if (!file_exists($this->rutaDatos)) {
            file_put_contents($this->rutaDatos, json_encode([]));
        }
    }

    // Obtener todas las imágenes
    public function obtenerImagenes(): array
    {
        $contenido = file_get_contents($this->rutaDatos);

        return json_decode($contenido, true) ?? [];
    }

    // Registrar una imagen
    public function guardarImagen(array $imagen): bool
    {
        $imagenes = $this->obtenerImagenes();

        $imagenes[] = $imagen;

        return file_put_contents(
            $this->rutaDatos,
            json_encode(
                $imagenes,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            ),
            LOCK_EX
        ) !== false;
    }

    // Eliminar una imagen del registro
    public function eliminarImagen(string $id): bool
    {
        $imagenes = $this->obtenerImagenes();

        $imagenes = array_filter(
            $imagenes,
            fn($imagen) => $imagen['id'] !== $id
        );

        return file_put_contents(
            $this->rutaDatos,
            json_encode(
                array_values($imagenes),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            ),
            LOCK_EX
        ) !== false;
    }
}
