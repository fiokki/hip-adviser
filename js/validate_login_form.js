document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault();

    // Funzione helper per mostrare errori
    const showError = (id, message) => {
        document.getElementById(`${id}Error`).innerHTML = message;
    };

    // Funzione helper per pulire errori
    const clearError = (id) => {
        document.getElementById(`${id}Error`).innerHTML = "";
    };

    // Ottenere i valori dagli input
    let email = document.getElementById("email").value;
    let pass = document.getElementById("pass").value;

    clearError("email");
    clearError("password");

    let hasError = false;

    if (email === "") {
        showError("email", "L'email è obbligatoria.");
        hasError = true;
    } 

    if (pass === "") {
        showError("password", "La password è obbligatoria.");
        hasError = true;
    } 

    // Se ci sono errori, non inviare il modulo
    if (hasError) {
        return;
    }

    const form = document.getElementById("loginForm");
    HTMLFormElement.prototype.submit.call(form);
});

    