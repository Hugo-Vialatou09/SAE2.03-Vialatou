let HOST_URL = '../server';
let DataMovie = {};

DataMovie.requestMovies = async function () {
    let answer = await fetch(HOST_URL + '/script.php?todo=getAllMovies');
    let movies = await answer.json();
    return movies;
};

DataMovie.requestMovieDetails = async function (movieId) {
    let answer = await fetch(HOST_URL + '/script.php?todo=readMovieDetail&id=' + movieId);
    let movie = await answer.json();
    return movie;
}
export {DataMovie};

DataMovie.requestMoviesCategory = async function (age) {
    const url  = HOST_URL + '/script.php?todo=readMovie&age=' + age;
    console.log(url);
    let answer = await fetch(url);
    let movies = await answer.json();
    console.log(movies);
    return movies;
};

DataMovie.getFavorites = async function (profileId) {

    let answer = await fetch(HOST_URL + '/script.php?todo=getFavorites&profile_id=' + profileId);
    let favorites = await answer.json();
    return favorites;
};

DataMovie.addFavorite = async function (profileId, movieId) {
    const url = `${HOST_URL}/script.php?todo=addFavorite&profile_id=${profileId}&movie_id=${movieId}`;
    console.log("URL de la requête d'ajout de favori :", url);
    let answer = await fetch(url);
    let response = await answer.json();
    return response;
};

DataMovie.removeFavorite = async function (profileId, movieId) {
    const url = `${HOST_URL}/script.php?todo=removeFavorites&profile_id=${profileId}&movie_id=${movieId}`;
    console.log("URL de la requête de suppression de favori :", url);
    let answer = await fetch(url);
    let response = await answer.json();
    return response;
}

DataMovie.requestMomentMovies = async function () {
    const url = HOST_URL + '/script.php?todo=getMomentMovies';
    let answer = await fetch(url);
    let movies = await answer.json();
    return movies;
  };
  