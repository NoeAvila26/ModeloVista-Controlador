<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generación de documentos</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .contenedor {
            max-width: 1000px;
            margin: auto;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }

        h1 {
            color: #263f60;
            margin: 0;
        }

        .volver {
            padding: 10px 16px;
            background: #e5eaf0;
            color: #263445;
            text-decoration: none;
            border-radius: 6px;
        }

        .descripcion {
            margin-bottom: 25px;
            color: #666;
        }

        .documentos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .tarjeta {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #00000010;
            text-align: center;
        }

        .icono {
            font-size: 45px;
            margin-bottom: 15px;
        }

        h2 {
            font-size: 20px;
            color: #263f60;
        }

        .tarjeta p {
            color: #666;
            min-height: 45px;
            line-height: 1.5;
        }

        .boton {
            display: inline-block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #263f60;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .boton:hover {
            background: #36577e;
        }

        @media (max-width: 750px) {
            .documentos {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    <header class="encabezado">
        <h1>Generación de documentos</h1>

        <a href="<?= site_url('inicio') ?>" class="volver">
            Volver al panel
        </a>
    </header>

    <p class="descripcion">
        Selecciona el formato que deseas generar y descargar.
    </p>

    <section class="documentos">

        <article class="tarjeta">
            <div class="icono">📘</div>

            <h2>Documento Word</h2>

            <p>Genera un documento editable en formato DOCX.</p>

            <form action="<?= site_url('documentos/word') ?>" method="post">
                <?= csrf_field() ?>

                <button type="submit" class="boton">
                    Generar Word
                </button>
            </form>
        </article>

        <article class="tarjeta">
            <div class="icono">📊</div>

            <h2>Archivo Excel</h2>

            <p>Genera una hoja de cálculo en formato XLSX.</p>

            <form action="<?= site_url('documentos/excel') ?>" method="post">
                <?= csrf_field() ?>

                <button type="submit" class="boton">
                    Generar Excel
                </button>
            </form>
        </article>

        <article class="tarjeta">
            <div class="icono">📕</div>

            <h2>Documento PDF</h2>

            <p>Genera un documento listo para consultar o imprimir.</p>

            <form action="<?= site_url('documentos/pdf') ?>" method="post">
                <?= csrf_field() ?>

                <button type="submit" class="boton">
                    Generar PDF
                </button>
            </form>
        </article>

    </section>

</div>

</body>
</html>
