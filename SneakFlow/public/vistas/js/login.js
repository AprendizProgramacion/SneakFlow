document.addEventListener('DOMContentLoaded', () => {
    const loginsec = document.querySelector('.login-section');
    const loginlink = document.querySelector('.login-link');
    const registerlink = document.querySelector('.register-link');

    console.log('loginsec:', loginsec);
    console.log('loginlink:', loginlink);
    console.log('registerlink:', registerlink);

    if (loginlink && registerlink && loginsec) {
        registerlink.addEventListener('click', (e) => {
            e.preventDefault();
            console.log('Registro seleccionado.');
            loginsec.classList.add('active');
        });

        loginlink.addEventListener('click', (e) => {
            e.preventDefault();
            console.log('Inicio de sesión seleccionado.');
            loginsec.classList.remove('active');
        });
    } else {
        console.error('No se encontraron los elementos necesarios.');
    }
});

