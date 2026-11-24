<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de imágenes</title>

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

        h1, h2 {
            color: #263f60;
        }

        h1 {
            margin: 0;
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

        .volver {
            background: #e5eaf0;
            color: #263445;
        }

        .principal {
            background: #263f60;
            color: white;
        }

        .formulario {
            background: white;
            padding: 22px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px #00000010;
        }

        .formulario label {
            display: block;
            margin-top: 15px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input[type="file"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .formulario button {
            margin-top: 18px;
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

        .galeria {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .tarjeta {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px #00000010;
        }

        .imagen {
            width: 100%;
            height: 210px;
            object-fit: cover;
            background: #e5eaf0;
        }

        .informacion {
            padding: 15px;
        }

        .informacion h3 {
            margin-top: 0;
            overflow-wrap: anywhere;
        }

        .informacion p {
            font-size: 13px;
            color: #666;
            overflow-wrap: anywhere;
        }

        .categoria {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 15px;
            background: #e5f1ff;
            color: #145ca8;
            font-size: 12px;
        }

        .eliminar {
            background: #ffe8e8;
            color: #b42318;
            width: 100%;
            margin-top: 10px;
        }

        .vacio {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            color: #777;
        }

        @media (max-width: 800px) {
            .galeria {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 550px) {
            body {
                padding: 15px;
            }

            .galeria {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    <header class="encabezado">
        <h1>Administración de imágenes</h1>

        <a href="<?= site_url('inicio') ?>" class="boton volver">
            Volver al panel
        </a>
    </header>

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

    <section class="formulario">

        <h2>Subir nueva imagen</h2>

        <p>Formatos permitidos: JPG y PNG. Tamaño máximo: 5 MB.</p>

        <form action="<?= site_url('imagenes/subir') ?>"
              method="post"
              enctype="multipart/form-data">

            <?= csrf_field() ?>

            <label for="imagen">Seleccionar imagen</label>

            <input type="file"
                   id="imagen"
                   name="imagen"
                   accept=".jpg,.jpeg,.png"
                   required>

            <label for="categoria">Categoría</label>

            <input type="text"
                   id="categoria"
                   name="categoria"
                   maxlength="50"
                   placeholder="Ejemplo: Productos, Eventos, General">

            <button type="submit" class="boton principal">
                Subir imagen
            </button>

        </form>

    </section>

    <section>

        <h2>Galería de imágenes</h2>

        <?php if (empty($imagenes)): ?>

            <div class="vacio">
                Todavía no hay imágenes registradas.
            </div>

        <?php else: ?>

            <div class="galeria">

                <?php foreach ($imagenes as $imagen): ?>

                    <article class="tarjeta">

                        <img
                            class="imagen"
                            src="<?= site_url('imagenes/ver/' . $imagen['id']) ?>"
                            alt="<?= esc($imagen['nombre_original']) ?>"
                        >

                        <div class="informacion">

                            <h3><?= esc($imagen['nombre_original']) ?></h3>

                            <span class="categoria">
                                <?= esc($imagen['categoria']) ?>
                            </span>

                            <p>
                                <?= number_format($imagen['tamano'] / 1024, 2) ?> KB
                            </p>

                            <p>
                                <?= esc($imagen['fecha']) ?>
                            </p>

                            <form
                                action="<?= site_url('imagenes/eliminar/' . $imagen['id']) ?>"
                                method="post"
                                onsubmit="return confirm('¿Deseas eliminar esta imagen?');">

                                <?= csrf_field() ?>

                                <button type="submit" class="boton eliminar">
                                    Eliminar imagen
                                </button>

                            </form>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>

</div>

</body>
</html>
