// Oggetto per tenere traccia dello stato dell'ordinamento per ogni filtro
let filterState = {
    release_date: 'DESC',    
    alphabetical: 'DESC',     
    top_rated: 'ASC',       
    highest_rated: 'ASC',
    most_albums: 'ASC',
    alphabetical_artists: 'DESC'
};

function getURLParams() {
    const urlParams = new URLSearchParams(window.location.search);
    const page = urlParams.get('page') || 'albums';
    const filter = urlParams.get('filter');
    const order = urlParams.get('order');

    // Se il filtro è presente nell'URL, aggiorniamo lo stato
    if (filter && filterState.hasOwnProperty(filter)) {
        filterState[filter] = order === 'ASC' ? 'ASC' : 'DESC';
    }

    // Aggiorna il pulsante del menu in base alla pagina corrente
    const filterLabel = document.querySelector(".filter-label");
    filterLabel.textContent = page === 'albums' ? "Ordina album per:" : "Ordina artisti per:";
}

// Funzione per applicare il filtro selezionato
function applyFilter(filterType) {
    // Alterna lo stato dell'ordinamento per il filtro selezionato
    if (filterState[filterType] === 'DESC') {
        filterState[filterType] = 'ASC'; // Passa a crescente (ASC)
    } else {
        filterState[filterType] = 'DESC'; // Passa a decrescente (DESC)
    }

    // Crea il nuovo URL con i parametri del filtro, dell'ordinamento e della pagina
    const newUrl = new URL(window.location.href);
    const currentPage = newUrl.searchParams.get('page') || 'albums'; // Default su "albums"
    newUrl.searchParams.set('page', currentPage); // Mantieni la pagina corrente
    newUrl.searchParams.set('filter', filterType);
    newUrl.searchParams.set('order', filterState[filterType]);
    
    // Reindirizza alla nuova URL
    window.location.href = newUrl.toString();
}

// Funzione per aprire/chiudere il menu a tendina
document.getElementById("filterButton").addEventListener("click", function() {
    const filterMenu = document.getElementById("filter-menu");
    filterMenu.classList.toggle("active");
});

// Al caricamento della pagina, leggiamo i parametri dell'URL
getURLParams();