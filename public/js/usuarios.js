// Confirmar antes de eliminar un usuario
document.addEventListener('DOMContentLoaded', function () {

    const formulariosEliminar = document.querySelectorAll('.form-eliminar');

    formulariosEliminar.forEach(function (formulario) {

        formulario.addEventListener('submit', function (evento) {

            const confirmar = confirm('¿Estás seguro de eliminar este usuario?');

            if (!confirmar) {
                evento.preventDefault();
            }

        });

    });

});