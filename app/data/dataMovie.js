let HOST_URL = 'https://mmi.unilim.fr/~vialatou2/SAE2.03-Vialatou';
let DataMovie = {};

DataMovie.requestMovies = async function () {
    let answer = await fetch(HOST_URL + '/server/script.php?todo=getAllMovies');
    let movies = await answer.json();
    return movies;
};

DataMovie.requestMovieDetails = async function (movieId) {
    let answer = await fetch(HOST_URL + '/server/script.php?todo=readMovieDetail&id=' + movieId);
    let movie = await answer.json();
    return movie;
}
export {DataMovie};

DataMovie.requestMoviesCategory = async function () {
    let answer = await fetch(HOST_URL + '/server/script.php?todo=readMovie');
    let movies = await answer.json();
    
    return movies;
}