
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>
</head>

<body>

    <h1>Editar usuario</h1>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <p><?= esc(session()->getFlashdata('mensaje')) ?></p>
    <?php endif; ?>

    <form action="<?= site_url('usuarios/actualizar/' . $usuario['id']) ?>" method="POST">

        <?= csrf_field() ?>

        <label>Nombre completo:</label>
        <input
            type="text"
            name="nombre"
            value="<?= esc($usuario['nombre']) ?>"
            required
        >
        <br><br>

        <label>Correo electrónico:</label>
        <input
            type="email"
            name="email"
            value="<?= esc($usuario['email']) ?>"
            required
        >
        <br><br>

        <label>Nueva contraseña (opcional):</label>
        <input
            type="password"
            name="password"
        >
        <br><br>

        <label>Fecha de cumpleaños:</label>
        <input
            type="date"
            name="birthday"
            value="<?= esc($usuario['birthday']) ?>"
            required
        >
        <br><br>

        <label>Lenguajes favoritos:</label>
        <br>

        <select name="languages[]" multiple required>

            <?php
            $opciones = ['JavaScript', 'Python', 'PHP', 'Java'];
            ?>

            <?php foreach ($opciones as $lenguaje): ?>

                <option
                    value="<?= esc($lenguaje) ?>"
                    <?= in_array($lenguaje, $usuario['languages']) ? 'selected' : '' ?>
                >
                    <?= esc($lenguaje) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <br><br>

        <button type="submit">Guardar cambios</button>

    </form>

    <br>

    <a href="<?= site_url('usuarios') ?>">Volver al listado</a>

</body>

</html>

