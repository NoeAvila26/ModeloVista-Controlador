<?php

namespace App\Controllers;

use App\Models\ImagenModel;

class Imagenes extends BaseController
{
    private function verificarSesion()
    {
        if (!session()->get('autenticado')) {
            return redirect()->to(site_url('login'));
        }

        return null;
    }

    // Mostrar galería
    public function index()
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $modelo = new ImagenModel();

        return view('imagenes/index', [
            'imagenes' => $modelo->obtenerImagenes()
        ]);
    }

    // Subir imagen
    public function subir()
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $imagen = $this->request->getFile('imagen');

        if (!$imagen || !$imagen->isValid()) {
            return redirect()->back()
                ->with('error', 'No se pudo recibir la imagen.');
        }

        // Obtener información antes de moverla
        $nombreOriginal = $imagen->getClientName();
        $tipo = $imagen->getMimeType();
        $tamano = $imagen->getSize();

        // Validar formatos
        $tiposPermitidos = [
            'image/jpeg',
            'image/png'
        ];

        if (!in_array($tipo, $tiposPermitidos, true)) {
            return redirect()->back()
                ->with('error', 'Solo se permiten imágenes JPG y PNG.');
        }

        // Limitar tamaño a 5 MB
        if ($tamano > 5 * 1024 * 1024) {
            return redirect()->back()
                ->with('error', 'La imagen no debe superar los 5 MB.');
        }

        // Validar que sea una imagen real
        if (@getimagesize($imagen->getTempName()) === false) {
            return redirect()->back()
                ->with('error', 'El archivo seleccionado no es una imagen válida.');
        }

        // Obtener categoría
        $categoria = trim($this->request->getPost('categoria') ?? '');

        if ($categoria === '') {
            $categoria = 'General';
        }

        $ruta = WRITEPATH . 'uploads/imagenes/';

        // Generar nombre interno
        $nombreSeguro = $imagen->getRandomName();

        if (!$imagen->move($ruta, $nombreSeguro)) {
            return redirect()->back()
                ->with('error', 'No se pudo guardar la imagen.');
        }

        $modelo = new ImagenModel();

        $resultado = $modelo->guardarImagen([
            'id' => bin2hex(random_bytes(8)),
            'nombre_original' => $nombreOriginal,
            'nombre_guardado' => $nombreSeguro,
            'tipo' => $tipo,
            'tamano' => $tamano,
            'categoria' => $categoria,
            'fecha' => date('Y-m-d H:i:s')
        ]);

        if (!$resultado) {
            if (is_file($ruta . $nombreSeguro)) {
                unlink($ruta . $nombreSeguro);
            }

            return redirect()->back()
                ->with('error', 'No se pudo registrar la imagen.');
        }

        return redirect()->to(site_url('imagenes'))
            ->with('mensaje', 'Imagen subida correctamente.');
    }

    // Eliminar imagen
    public function eliminar($id)
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $modelo = new ImagenModel();
        $imagenes = $modelo->obtenerImagenes();

        foreach ($imagenes as $imagen) {
            if ($imagen['id'] === $id) {

                $ruta = WRITEPATH . 'uploads/imagenes/'
                    . $imagen['nombre_guardado'];

                if (is_file($ruta)) {
                    unlink($ruta);
                }

                $modelo->eliminarImagen($id);

                return redirect()->to(site_url('imagenes'))
                    ->with('mensaje', 'Imagen eliminada correctamente.');
            }
        }

        return redirect()->back()
            ->with('error', 'No se encontró la imagen.');
    }


    // Mostrar una imagen de forma segura
    public function ver($id)
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $modelo = new ImagenModel();
        $imagenes = $modelo->obtenerImagenes();

        foreach ($imagenes as $imagen) {
            if ($imagen['id'] === $id) {

                $ruta = WRITEPATH . 'uploads/imagenes/'
                    . $imagen['nombre_guardado'];

                if (!is_file($ruta)) {
                    return $this->response->setStatusCode(404);
                }

                return $this->response
                    ->setContentType($imagen['tipo'])
                    ->setHeader('X-Content-Type-Options', 'nosniff')
                    ->setBody(file_get_contents($ruta));
            }
        }

        return $this->response->setStatusCode(404);
    }

}
