document.getElementById("registrationForm").addEventListener("submit", function (event) {
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
    let firstname = document.getElementById("firstname").value;
    let lastname = document.getElementById("lastname").value;
    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("pass").value;
    let retypePassword = document.getElementById("confirm").value;

    clearError("firstname");
    clearError("lastname");
    clearError("username");
    clearError("email");
    clearError("password");
    clearError("retypePassword");

    let hasError = false;

    if (firstname === "") {
        showError("firstname", "Il nome è obbligatorio.");
        hasError = true;
    }

    if (lastname === "") {
        showError("lastname", "Il cognome è obbligatorio.");
        hasError = true;
    }
  
    /*if (username === "") {
        showError("username", "Lo username è obbligatorio.");
        hasError = true;
    }*/

    if (email === "") {
        showError("email", "L'email è obbligatoria.");
        hasError = true;
    } else if (!/\S+@\S+\.\S+/.test(email)) { // RegEx base per validazione email
        showError("email", "Inserisci un'email valida.");
        hasError = true;
    }

    if (password === "") {
        showError("password", "La password è obbligatoria.");
        hasError = true;
    } else if (password.length < 8) {
        showError("password", "La password deve avere almeno 8 caratteri.");
        hasError = true;
    }

    if (retypePassword === "") {
        showError("retypePassword", "La conferma password è obbligatoria.");
        hasError = true;
    } else if (password !== retypePassword) {
        showError("retypePassword", "Le password inserite non corrispondono.");
        hasError = true;
    }

   // Se non abbiamo riscontrato errori, controlliamo se l'email è già in uso
   if (!hasError) {
    // Usiamo Fetch API per verificare l'email
    fetch("php/checkemail.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({ email: email }), // Costruisce i dati in formato application/x-www-form-urlencoded
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Errore nella richiesta al server");
        }
        return response.json();
    })
    .then(data => {
        if (data.exists) {
            showError("email", "L'indirizzo email è già in uso");
        } else {
            const form = document.getElementById("registrationForm");
            HTMLFormElement.prototype.submit.call(form);
        }
    })
    .catch(error => {
        console.error("Errore:", error);
        showError("email", "Si è verificato un problema durante la verifica dell'email.");
    });
}
});
