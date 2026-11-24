<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de archivos</title>

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
            max-width: 1100px;
            margin: auto;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
            color: #263445;
        }

        .boton {
            display: inline-block;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .principal {
            background: #263f60;
            color: white;
        }

        .secundario {
            background: #e5eaf0;
            color: #263445;
        }

        .subir {
            background: white;
            padding: 22px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px #00000010;
        }

        input[type="file"] {
            display: block;
            margin: 15px 0;
            max-width: 100%;
        }

        .tabla-contenedor {
            overflow-x: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px #00000010;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #263f60;
            color: white;
        }

        .acciones {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .descargar {
            background: #e5f1ff;
            color: #145ca8;
        }

        .eliminar {
            background: #ffe8e8;
            color: #b42318;
        }

        .mensaje {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            background: #e4f7e9;
            color: #176b32;
        }

        .error {
            background: #ffe8e8;
            color: #b42318;
        }

        .vacio {
            padding: 25px;
            text-align: center;
            color: #777;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .encabezado {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    <div class="encabezado">
        <h1>Administración de archivos</h1>

        <a href="<?= site_url('inicio') ?>" class="boton secundario">
            Volver al panel
        </a>
    </div>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="mensaje">
            <?= esc(session()->getFlashdata('mensaje')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mensaje error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <section class="subir">

        <h2>Subir nuevo archivo</h2>

        <p>Formatos permitidos: PDF, JPG y PNG. Tamaño máximo: 5 MB.</p>

        <form action="<?= site_url('archivos/subir') ?>"
              method="post"
              enctype="multipart/form-data">

            <?= csrf_field() ?>

            <input type="file"
                   name="archivo"
                   accept=".pdf,.jpg,.jpeg,.png"
                   required>

            <button type="submit" class="boton principal">
                Subir archivo
            </button>

        </form>

    </section>

    <section>

        <h2>Archivos registrados</h2>

        <div class="tabla-contenedor">

            <table>

                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Tamaño</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (empty($archivos)): ?>

                        <tr>
                            <td colspan="5" class="vacio">
                                Todavía no hay archivos registrados.
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php foreach ($archivos as $archivo): ?>

                            <tr>
                                <td><?= esc($archivo['nombre_original']) ?></td>

                                <td><?= esc($archivo['tipo']) ?></td>

                                <td>
                                    <?= number_format($archivo['tamano'] / 1024, 2) ?> KB
                                </td>

                                <td><?= esc($archivo['fecha']) ?></td>

                                <td>
                                    <div class="acciones">

                                        <a class="boton descargar"
                                           href="<?= site_url('archivos/descargar/' . $archivo['id']) ?>">
                                            Descargar
                                        </a>

                                        <form action="<?= site_url('archivos/eliminar/' . $archivo['id']) ?>"
                                              method="post"
                                              onsubmit="return confirm('¿Deseas eliminar este archivo?');">

                                            <?= csrf_field() ?>

                                            <button type="submit" class="boton eliminar">
                                                Eliminar
                                            </button>

                                        </form>

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>

</div>

</body>
</html>
