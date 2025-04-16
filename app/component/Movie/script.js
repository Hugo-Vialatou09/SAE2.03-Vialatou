let templateFile = await fetch('./component/Movie/template.html');
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movies, profileId, favorites) {
    let html = "";
    favorites = Array.isArray(favorites) ? favorites : [];
    for (let movie of movies) {
        let movieHtml = template;
        movieHtml = movieHtml.replace("{{titre}}", movie.name);
        movieHtml = movieHtml.replace("{{image}}", movie.image);
        movieHtml = movieHtml.replace("{{image1}}", movie.image);
        movieHtml = movieHtml.replace("{{handler}}", `C.handlerDetail(${movie.id})`);

        let isFavorites = false;
        for (let fav of favorites) {
            if (fav.id == movie.id) {
                isFavorites = true;
                break;
            }
        }
        let favoriteButton = isFavorites
            ? `<button disabled>Favori</button>`
            : `<button class="button__favorites" onclick="C.addFavorite(${profileId}, ${movie.id})">Ajouter aux favoris !</button>`;
            
        
        
        // Remplacer le placeholder par le bouton
        movieHtml = movieHtml.replace("{{favoriteButton}}", favoriteButton);
        
        html += movieHtml;
    }
    return html;
}

export { Movie };
