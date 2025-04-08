import { Movie } from "../Movie/script";

let templateFile = await fetch('./component/MovieCategory/template.html');
let template = await templateFile.text();

let MovieCategory = {};
MovieCategory.format = function (category) {
    let html = template;
    html = html.replace("{{categoryName}}", category.name);

    let moviesListHtml = Movie.format(category.movies || []);
    html = html.replace("{{movieCard}}", moviesListHtml);

    return html;
    };


export { MovieCategory };