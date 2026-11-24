
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>

    <h1>Acceso de usuarios</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>
    <?php endif; ?>

    <form action="<?= site_url('autenticar') ?>" method="POST">

        <?= csrf_field() ?>

        <div>
            <label for="email">Correo electrónico:</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= esc($correoRecordado ?? '') ?>"
                required
            >
        </div>

        <br>

        <div>
            <label for="password">Contraseña:</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <br>

        <div>
            <input
                type="checkbox"
                id="recordar"
                name="recordar"
                value="1"
            >
            <label for="recordar">Recordar mi correo</label>
        </div>

        <br>

        <button type="submit">Iniciar sesión</button>

    </form>

</body>
</html>
