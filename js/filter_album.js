// Oggetto per tenere traccia dello stato dell'ordinamento per ogni filtro
let filterState = {
    release_date: 'DESC',    // Impostazione iniziale per "release_date" (dal più recente)
    alphabetical: 'ASC',     // Impostazione iniziale per "alphabetical" (A-Z)
    top_rated: 'DESC',       // Impostazione iniziale per "top_rated" (dal più votato)
    highest_rated: 'DESC'    // Impostazione iniziale per "highest_rated" (media migliore)
};

// Funzione per applicare il filtro selezionato
function applyFilter(filterType) {
    // Alterna lo stato dell'ordinamento per il filtro selezionato
    if (filterState[filterType] === 'DESC') {
        filterState[filterType] = 'ASC'; // Passa a crescente (ASC)
    } else {
        filterState[filterType] = 'DESC'; // Passa a decrescente (DESC)
    }

    // Crea la nuova URL con i parametri del filtro e dell'ordinamento
    const newUrl = new URL(window.location.href);
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
