<?php if (isset($_SESSION['mensaje'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Carga solo si es necesario -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar alerta personalizada con SweetAlert2
            Swal.fire({
                title: '<?php echo $_SESSION['mensaje']['tipo'] === 'success' ? '¡Éxito!' : ($_SESSION['mensaje']['tipo'] === 'error' ? '¡Error!' : 'Advertencia'); ?>',
                text: '<?php echo htmlspecialchars($_SESSION['mensaje']['texto']); ?>',
                icon: '<?php echo $_SESSION['mensaje']['tipo']; ?>', // success, error, warning, info
                showConfirmButton: false, // No mostrar el botón de confirmación
                timer: 1000, // Tiempo en milisegundos antes de cerrar la alerta
                background: '#1e1e2f',
                color: '#fff',
                backdrop: `
                    rgba(0,0,0,0.5) 
                `,
                willClose: () => {
                    // Elimina el mensaje de la sesión después de que la alerta se haya cerrado
                    <?php unset($_SESSION['mensaje']); ?>
                }
            });
        });
    </script>
<?php endif; ?>
