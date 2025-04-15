let templateFile = await fetch('./component/Movie/template.html');
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movies, profileId, favorites) {
    let html = "";
    favorites = Array.isArray(favorites) ? favorites : [];
    for (let i = 0; i < movies.length; i++) {
        let movie = movies[i];
        let movieHtml = template;
        movieHtml = movieHtml.replace("{{titre}}", movie.name);
        movieHtml = movieHtml.replace("{{image}}", movie.image);
        movieHtml = movieHtml.replace("{{image1}}", movie.image);
        movieHtml = movieHtml.replace("{{handler}}", `C.handlerDetail(${movie.id})`);
        let isFavorite =false;
        for (let fav of favorites) {
            if ( fav.id == movie.id) {
                isFavorite = true;
                break;
            }
        }
        const favoriteButton = isFavorite 
        ? `<button class="Favorite-button_disabled" disabled>Favori</button>`
        : `<button class:"Favorite-button" onclick="C.addFavorite(${profileId}, ${movie.id})">Ajouter aux favoris</button>`;
        movieHtml += favoriteButton; 
        html += movieHtml;
    }
        
    
    return html;
};

export { Movie };
