
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de usuarios</title>
</head>

<body>

    <h1>Administración de usuarios</h1>

    

    <?php if (session()->getFlashdata('mensaje')): ?>
    <p>
        <?= esc(session()->getFlashdata('mensaje')) ?>
    </p>
<?php endif; ?>

    <a href="<?= site_url('usuarios/crear') ?>">
        Crear nuevo usuario
    </a>

    <hr>
    
    <form action="<?= site_url('salir') ?>" method="POST">
    <?= csrf_field() ?>
    <button type="submit">Cerrar sesión</button>
</form>

    <h2>Listado de usuarios</h2>

    <?php if (!empty($usuarios)): ?>

        <table border="1" cellpadding="10">

            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
                    <th>Fecha de cumpleaños</th>
                    <th>Lenguajes favoritos</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($usuarios as $usuario): ?>

                    <tr>
                        <td><?= esc($usuario['nombre']) ?></td>

                        <td><?= esc($usuario['email']) ?></td>

                        <td><?= esc($usuario['birthday']) ?></td>

                        <td>
                            <?= esc(implode(', ', $usuario['languages'])) ?>
                        </td>

                        <td>
                            <a href="<?= site_url('usuarios/editar/' . $usuario['id']) ?>">Editar</a>

                            <form action="<?= site_url('usuarios/eliminar/' . $usuario['id']) ?>" method="POST" class="form-eliminar" style="display: inline;">
                                <?= csrf_field() ?>
                                <button type="submit">
                                    Borrar
                                </button>
                            </form>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php else: ?>

        <p>Aún no hay usuarios registrados.</p>

    <?php endif; ?>
<script src="<?= base_url('js/usuarios.js') ?>"></script>
</body>

</html>
