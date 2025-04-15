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

DataMovie.requestMoviesCategory = async function (age) {
    const url  = HOST_URL + '/server/script.php?todo=readMovie&age=' + age;
    console.log(url);
    let answer = await fetch(url);
    let movies = await answer.json();
    console.log(movies);
    return movies;
};

DataMovie.getFavorites = async function (profileId) {

    let answer = await fetch(HOST_URL + '/server/script.php?todo=getFavorites&profile_Id=' + profileId);
    let favorites = await answer.json();
    return favorites;
};

DataMovie.addFavorite = async function (profileId, movieId) {
    const url = `${HOST_URL}/server/script.php?todo=addFavorite&profile_id=${profileId}&movie_id=${movieId}`;

    let answer = await fetch(url);
    let response = await answer.json();
    return response;
};