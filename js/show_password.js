const passwordInput = document.getElementById('pass');
const togglePasswordButton = document.getElementById('togglePassword');

togglePasswordButton.addEventListener('mousedown', () => {
    passwordInput.type = 'text'; // Mostra la password
});

togglePasswordButton.addEventListener('mouseup', () => {
    passwordInput.type = 'password'; // Nasconde la password
});

togglePasswordButton.addEventListener('mouseleave', () => {
    passwordInput.type = 'password'; // Nasconde la password
});