
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario</title>
</head>

<body>

    <h1>Crear nuevo usuario</h1>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <p><?= esc(session()->getFlashdata('mensaje')) ?></p>
    <?php endif; ?>

    <form action="<?= site_url('usuarios/guardar') ?>" method="POST">

        <?= csrf_field() ?>

        <label>Nombre completo:</label>
        <input type="text" name="nombre" required>
        <br><br>

        <label>Correo electrónico:</label>
        <input type="email" name="email" required>
        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <br><br>

        <label>Fecha de cumpleaños:</label>
        <input type="date" name="birthday" required>
        <br><br>

        <label>Lenguajes favoritos:</label>
        <br>

        <select name="languages[]" multiple required>
            <option value="JavaScript">JavaScript</option>
            <option value="Python">Python</option>
            <option value="PHP">PHP</option>
            <option value="Java">Java</option>
        </select>

        <br><br>

        <button type="submit">Registrar usuario</button>

    </form>

    <br>

    <a href="<?= site_url('usuarios') ?>">Volver al listado</a>

</body>

</html>
