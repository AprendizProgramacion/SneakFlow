<?php require_once '../public/vistas/header.php'; ?>
<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
<link rel="stylesheet" href="/SneakFlow/public/vistas/css/contacto.css">
<br>
<div class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 rounded-lg p-8 shadow-lg w-full max-w-2xl flex">
        <div class="w-1/2 pr-4">
            <h1 class="text-3xl font-bold text-center mb-6">Contáctanos <span class="text-green-400">Us</span></h1>
            <div class="animated bounceInUp">
                <div class="contact-form">
                    <h3 class="text-xl mb-4">Contáctanos</h3>

                    <!-- Mensaje de éxito o error -->
                    <div class="alert alert-success" style="display: none;"></div>
                    <div class="alert alert-danger" style="display: none;"></div>

                    <form id="contactoForm" action="enviar-contacto" method="POST" class="space-y-4">
                        <input type="text" name="nombre_completo" placeholder="Nombre Completo" class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        <input type="email" name="email" placeholder="Correo Electrónico" class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        <input type="text" name="asunto" placeholder="Asunto" class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        <textarea name="mensaje" rows="3" placeholder="Mensaje" class="w-full p-2 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-green-400" required></textarea>
                        <button class="w-full bg-green-700 hover:bg-green-700 p-2 rounded text-white font-bold transition duration-200">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="w-1/2 pl-4">
            <div class="contact-info mt-8">
                <h4 class="text-lg font-semibold">Más Información</h4>
                <ul class="mt-2 space-y-2">
                    <li><i class="fas fa-map-marker-alt"></i> Villeta</li>
                    <li><i class="fas fa-envelope-open-text"></i> sn3akflow@gmail.com</li>
                </ul>
                <p class="mt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero provident ipsam necessitatibus repellendus?</p>
                <p>SneakFlow.com</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para mostrar la alerta y luego recargar la página
    function mostrarAlerta(tipo, mensaje) {
        const alertDiv = document.querySelector(`.alert-${tipo}`);
        alertDiv.innerHTML = mensaje;
        alertDiv.style.display = 'block'; // Mostrar la alerta

        // Esperar 3 segundos y recargar la página
        setTimeout(() => {
            alertDiv.style.display = 'none'; // Ocultar la alerta
            window.location.reload(); // Recargar la página
        }, 3000);
    }

    // Función para manejar el envío del formulario mediante AJAX
    function enviarFormulario(event) {
        event.preventDefault(); // Evitar el envío normal del formulario

        const form = event.target;
        const formData = new FormData(form);

        fetch('enviar-contacto', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarAlerta('success', data.message);
            } else {
                mostrarAlerta('danger', data.message);
            }
        })
        .catch(error => {
            mostrarAlerta('danger', 'Ocurrió un error al enviar el formulario.');
        });
    }

    // Asociar la función de envío al formulario
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#contactoForm');
        form.addEventListener('submit', enviarFormulario);
    });
</script>

<?php require_once '../public/vistas/footer.php'; ?>
