let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

MovieDetail.format = function (movieData) {
  let html = template;
  html = html.replace("{{movieTitle}}", movieData.name);
  html = html.replace("{{movieImg}}", movieData.image);
  html = html.replace("{{movieSynopsis}}", movieData.description);
  html = html.replace("{{movieDirector}}", movieData.director);
  html = html.replace("{{movieYear}}", movieData.year );
  html = html.replace("{{movieCategory}}", movieData.category );
  html = html.replace("{{movieAge}}", movieData.min_age);
  html = html.replace("{{movieTrailerUrl}}", movieData.trailer);
  return html;
};

export { MovieDetail };