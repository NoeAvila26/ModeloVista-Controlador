<?php

namespace App\Controllers;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Documentos extends BaseController
{
    // Verificar sesión
    private function verificarSesion()
    {
        if (!session()->get('autenticado')) {
            return redirect()->to(site_url('login'));
        }

        return null;
    }

    // Mostrar panel de generación de documentos
    public function index()
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        return view('documentos/index');
    }

    // Generar documento Word
    public function word()
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $documento = new PhpWord();

        $seccion = $documento->addSection();

        $seccion->addTitle('Documento de ejemplo', 1);

        $seccion->addText(
            'Este documento fue generado desde el sistema MVC.'
        );

        $seccion->addText(
            'Fecha de generación: ' . date('d/m/Y H:i:s')
        );

        $ruta = tempnam(WRITEPATH . 'cache/', 'word_');

        $writer = \PhpOffice\PhpWord\IOFactory::createWriter(
            $documento,
            'Word2007'
        );

        $writer->save($ruta);

        return $this->response
            ->download($ruta, null)
            ->setFileName('documento_ejemplo.docx')
            ->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    }

    // Generar archivo Excel
    public function excel()
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $libro = new Spreadsheet();

        $hoja = $libro->getActiveSheet();

        $hoja->setCellValue('A1', 'REPORTE DEL SISTEMA MVC');
        $hoja->setCellValue('A2', 'Fecha de generación');
        $hoja->setCellValue('B2', date('d/m/Y H:i:s'));

        $hoja->setCellValue('A4', 'ID');
        $hoja->setCellValue('B4', 'Nombre');
        $hoja->setCellValue('C4', 'Estado');

        $hoja->setCellValue('A5', 1);
        $hoja->setCellValue('B5', 'Documento de ejemplo');
        $hoja->setCellValue('C5', 'Generado');

        $hoja->getStyle('A1:C1')->getFont()->setBold(true);
        $hoja->getStyle('A4:C4')->getFont()->setBold(true);

        foreach (['A', 'B', 'C'] as $columna) {
            $hoja->getColumnDimension($columna)->setAutoSize(true);
        }

        $ruta = tempnam(WRITEPATH . 'cache/', 'excel_');

        $writer = new Xlsx($libro);
        $writer->save($ruta);

        return $this->response
            ->download($ruta, null)
            ->setFileName('reporte_ejemplo.xlsx')
            ->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    // Generar documento PDF
    public function pdf()
    {
        if ($respuesta = $this->verificarSesion()) {
            return $respuesta;
        }

        $html = '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <style>
                    body {
                        font-family: DejaVu Sans, sans-serif;
                        color: #333;
                        margin: 40px;
                    }

                    h1 {
                        color: #263f60;
                        text-align: center;
                    }

                    p {
                        font-size: 14px;
                    }
                </style>
            </head>
            <body>
                <h1>Documento de ejemplo</h1>
                <p>Este documento PDF fue generado desde el sistema MVC.</p>
                <p>Fecha de generación: ' . date('d/m/Y H:i:s') . '</p>
            </body>
            </html>
        ';

        $pdf = new Dompdf();

        $pdf->loadHtml($html, 'UTF-8');
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $ruta = tempnam(WRITEPATH . 'cache/', 'pdf_');

        file_put_contents($ruta, $pdf->output());

        return $this->response
            ->download($ruta, null)
            ->setFileName('documento_ejemplo.pdf')
            ->setContentType('application/pdf');
    }
}
