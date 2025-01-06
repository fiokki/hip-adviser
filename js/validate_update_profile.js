document.getElementById("updateForm").addEventListener("submit", function (event) {
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

    clearError("firstname");
    clearError("lastname");
    clearError("username");
    clearError("email");

    let hasError = false;


    if (firstname === "") {
        showError("firstname", "Il nome è obbligatorio.");
        hasError = true;
    } else if (firstname.length > 30) {
        showError("firstname", "Il nome non può superare i 30 caratteri.");
        hasError = true;
    }

    if (lastname === "") {
        showError("lastname", "Il cognome è obbligatorio.");
        hasError = true;
    } else if (lastname.length > 30) {
        showError("lastname", "Il cognome non può superare i 30 caratteri.");
        hasError = true;
    }

    if (username.length > 20) {
        showError("username", "Il nome utente non può superare i 20 caratteri.");
        hasError = true;
    }

    if (email === "") {
        showError("email", "L'email è obbligatoria.");
        hasError = true;
    } else if (!/\S+@\S+\.\S+/.test(email)) { // RegEx base per validazione email
        showError("email", "Inserisci un'email valida.");
        hasError = true;
    } else if (email.length > 50) {
        showError("email", "L'indirizzo email non può superare i 50 caratteri.");
        hasError = true;
    }

    if(!hasError){
        fetch("php/update_profile.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ firstname, lastname, username, email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Profilo aggiornato con successo. Sarai reindirizzato al profilo tra 3 secondi.");
                setTimeout(function() {
                    window.location.href = '../show_profile.php';
                }, 3000);
            } else {
                alert(data.message || "Errore nell'update.");
            }

        })
        .catch(error => {
            console.error("Errore durante l'update:", error);
            showError("update", "Errore del server. Riprovi più tardi.")
        });
    }
    else{
        alert("erroreeee");
    }
});

    