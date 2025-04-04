let HOST_URL = 'https://mmi.unilim.fr/~vialatou2/SAE2.03-Vialatou';
let DataMovie = {};

DataMovie.requestMovies = async function () {
    let answer = await fetch(HOST_URL + '/server/script.php?todo=getAllMovies');
    let movies = await answer.json();
    return movies;
};

export {DataMovie};