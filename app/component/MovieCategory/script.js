import { Movie } from "../Movie/script";

let templateFile = await fetch('./component/MovieCategory/template.html');
let template = await templateFile.text();

let MovieCategory = {};
MovieCategory.format = function (category) {
    let html = template;
    html = html.replace("{{categoryName}}", category.name);
    html = html.replace("{{categoryId}}", category.id || Math.random().toString(36).substring(2, 9));

    let moviesListHtml = Movie.format(category.movies || []);
    html = html.replace("{{movieCard}}", moviesListHtml);

    return html;
};

// Fonction de défilement du carrousel
window.scrollCarousel = function(button, direction) {
    const container = button.parentElement.querySelector('.movies');
    const scrollAmount = container.clientWidth * 0.8; // 80% de la largeur visible
    
    if (direction === 'left') {
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else {
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
};

export { MovieCategory };