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
    let password = document.getElementById("pass").value;

    clearError("email");
    clearError("password");

    let hasError = false;

    if (email === "") {
        showError("email", "L'email è obbligatoria.");
        hasError = true;
    } 

    if (password === "") {
        showError("password", "La password è obbligatoria.");
        hasError = true;
    } 

    // Se non abbiamo riscontrato errori, controlliamo backend che l'utente sia registrato effettivamente, ed abbia inserito la password corretta
    fetch("login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email, password }) // Trasformiamo i dati in stringa JSON 
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect alla homepage se il login ha successo
            window.location.href = "homepage.php";
        } else {
            // Se il login non ha successo mostriamo il messaggio di errore, specifico (data.message) se presente, altrimenti 'credenziali errate'
            showError("login", data.message || "Credenziali errate.")
        }
    })
    .catch(error => {
        console.error("Errore durante il login:", error);
        showError("login", "Errore del server. Riprovi più tardi.")
    });
    
});

    