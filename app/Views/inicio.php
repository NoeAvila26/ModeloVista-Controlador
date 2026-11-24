<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administración</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        header {
            background: #263746;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        main {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .bienvenida {
            margin-bottom: 30px;
        }

        .modulos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .modulo {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        .modulo h2 {
            font-size: 20px;
            margin-bottom: 12px;
        }

        .modulo p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .modulo a {
            display: inline-block;
            background: #2878b5;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .modulo a:hover {
            background: #195b8d;
        }

        .salir {
            color: white;
            background: #bd4141;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            header {
                padding: 18px;
                gap: 15px;
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

<header>
    <h1>Panel de administración</h1>

    <form action="<?= site_url('salir') ?>" method="POST">
        <?= csrf_field() ?>
        <button type="submit" class="salir">Cerrar sesión</button>
    </form>
</header>

<main>

    <section class="bienvenida">
        <h2>Bienvenido, <?= esc($usuario) ?></h2>
        <p>Selecciona el módulo que deseas administrar.</p>
    </section>

    <section class="modulos">

        <article class="modulo">
            <h2>Usuarios</h2>
            <p>Administra los usuarios registrados en el sistema.</p>
            <a href="<?= site_url('usuarios') ?>">Acceder</a>
        </article>

        <article class="modulo">
            <h2>Archivos</h2>
            <p>Sube, consulta, descarga y elimina archivos.</p>
            <a href="<?= site_url('archivos') ?>">Acceder</a>
        </article>

        <article class="modulo">
            <h2>Documentos</h2>
            <p>Genera documentos en formatos Word, Excel y PDF.</p>
            <a href="<?= site_url('documentos') ?>">Acceder</a>
        </article>

        <article class="modulo">
            <h2>Imágenes</h2>
            <p>Administra y organiza tus imágenes.</p>
            <a href="<?= site_url('imagenes') ?>">Acceder</a>
        </article>

    </section>

</main>

</body>
</html>
