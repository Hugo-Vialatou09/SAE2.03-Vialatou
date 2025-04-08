let templateFile = await fetch('./component/Movie/template.html');
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movies) {
let html = "";
movies.forEach((movie) => {
    let movieHtml = template;
    movieHtml = movieHtml.replace("{{titre}}", movie.name);
    movieHtml = movieHtml.replace("{{image}}", movie.image);
    movieHtml = movieHtml.replace("{{image1}}", movie.image);
    html += movieHtml;
});
return html;
};
export {Movie};