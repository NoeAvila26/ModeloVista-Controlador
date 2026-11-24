<?php

namespace App\Controllers;

use App\Models\ArchivoModel;

class Archivos extends BaseController
{
    private function verificarSesion()
    {
        if (!session()->get('autenticado')) {
            return redirect()->to(site_url('login'));
        }

        return null;
    }

    // Mostrar el listado de archivos
    public function index()
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $modelo = new ArchivoModel();

        return view('archivos/index', [
            'archivos' => $modelo->obtenerArchivos()
        ]);
    }

 
public function subir()
{
    if ($respuesta = $this->verificarSesion()) {
        return $respuesta;
    }

    $archivo = $this->request->getFile('archivo');

    if (!$archivo || !$archivo->isValid()) {
        return redirect()->back()
            ->with('error', 'No se pudo recibir el archivo.');
    }

    // Obtener los datos ANTES de mover el archivo
    $nombreOriginal = $archivo->getClientName();
    $tipo = $archivo->getMimeType();
    $tamano = $archivo->getSize();

    // Tipos permitidos
    $tiposPermitidos = [
        'application/pdf',
        'image/jpeg',
        'image/png'
    ];

    if (!in_array($tipo, $tiposPermitidos, true)) {
        return redirect()->back()
            ->with('error', 'Solo se permiten archivos PDF, JPG y PNG.');
    }

    // Límite de 5 MB
    if ($tamano > 5 * 1024 * 1024) {
        return redirect()->back()
            ->with('error', 'El archivo no debe superar los 5 MB.');
    }

    $ruta = WRITEPATH . 'uploads/archivos/';

    // Generar un nombre único
    $nombreSeguro = $archivo->getRandomName();

    // Mover el archivo
    if (!$archivo->move($ruta, $nombreSeguro)) {
        return redirect()->back()
            ->with('error', 'No se pudo guardar el archivo.');
    }

    // Registrar los datos
    $modelo = new ArchivoModel();

    $resultado = $modelo->guardarArchivo([
        'id' => bin2hex(random_bytes(8)),
        'nombre_original' => $nombreOriginal,
        'nombre_guardado' => $nombreSeguro,
        'tipo' => $tipo,
        'tamano' => $tamano,
        'fecha' => date('Y-m-d H:i:s')
    ]);

    if (!$resultado) {
        if (is_file($ruta . $nombreSeguro)) {
            unlink($ruta . $nombreSeguro);
        }

        return redirect()->back()
            ->with('error', 'No se pudo registrar el archivo.');
    }

    return redirect()->to(site_url('archivos'))
        ->with('mensaje', 'Archivo subido correctamente.');
}


    // Descargar un archivo
    public function descargar($id)
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $modelo = new ArchivoModel();
        $archivos = $modelo->obtenerArchivos();

        foreach ($archivos as $archivo) {
            if ($archivo['id'] === $id) {

                $ruta = WRITEPATH . 'uploads/archivos/'
                    . $archivo['nombre_guardado'];

                if (!is_file($ruta)) {
                    return redirect()->back()
                        ->with('error', 'El archivo no existe.');
                }

                return $this->response
                    ->download($ruta, null)
                    ->setFileName($archivo['nombre_original']);
            }
        }

        return redirect()->back()
            ->with('error', 'No se encontró el archivo.');
    }

    // Eliminar un archivo
    public function eliminar($id)
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $modelo = new ArchivoModel();
        $archivos = $modelo->obtenerArchivos();

        foreach ($archivos as $archivo) {
            if ($archivo['id'] === $id) {

                $ruta = WRITEPATH . 'uploads/archivos/'
                    . $archivo['nombre_guardado'];

                if (is_file($ruta)) {
                    unlink($ruta);
                }

                $modelo->eliminarArchivo($id);

                return redirect()->to(site_url('archivos'))
                    ->with('mensaje', 'Archivo eliminado correctamente.');
            }
        }

        return redirect()->back()
            ->with('error', 'No se encontró el archivo.');
    }
}
