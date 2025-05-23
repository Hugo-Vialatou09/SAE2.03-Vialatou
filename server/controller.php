<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à includre dans la réponse HTTP.
 */

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");

function readMoviesController(){
  // on appelle la fonction de modèle readMovies() pour récupérer les films
  $movies = getAllMovies();
    return $movies;
}

function addController(){
    
  $name = $_REQUEST['name'];
  $director = $_REQUEST['director'];
  $year = $_REQUEST['year'];
  $length = $_REQUEST['length'];
  $description = $_REQUEST['description'];
  $id_category = $_REQUEST['id_category'];
  $image = $_REQUEST['image'];
  $trailer = $_REQUEST['trailer'];
  $min_age = $_REQUEST['min_age'];

  // Appel de la fonction addMovie déclarée dans model.php pour ajouter un film à la BDD
  $ok = addMovie($name, $director, $year, $length, $description,$id_category,$image, $trailer, $min_age);
 
  if ($ok!=0){
      return "$name a été ajouté avec succès";
    }
    else{
      return "Le film n'a pas pu être ajouté";
    }
}

function readMovieDetailController() {

  if (!isset($_REQUEST['id'])) {
      return false; 
  }

  $id = intval($_REQUEST['id']);
  $movie = getMovieDetail($id);

  if ($movie) {
      return $movie;
  } else {
      return false;
  }
}

function readMoviesByCategoryController() {
  $age = 0;
  if (isset($_REQUEST['age'])) {
      $age = $_REQUEST['age'];
  }
  // var_dump($age);
  $categories = getMoviesByCategory($age);
  if ($categories) {
    return $categories; 
} else {

    return false; 
}
}

function addProfileController(){
  
  $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
  $name = $_REQUEST['name'];
  $avatar = $_REQUEST['avatar'];
  $min_age = $_REQUEST['min_age'];

  $ok = addProfile($id, $name, $avatar, $min_age);
 
  if ($ok!=0){
      return "$name a été ajouté avec succès";
    }
    else{
      return "Le profil n'a pas pu être ajouté";
    }
}

function readProfileController(){
  $profile = getAllProfile();
  return $profile ? $profile : [];    
} 

function addFavoriteController(){
  $profile_id = $_REQUEST['profile_id'];
  $movie_id = $_REQUEST['movie_id'];

  if (isFavorite($profile_id, $movie_id)) {
      return "Le film est déjà dans vos favoris.";
  }

  $ok = addFavorites($profile_id, $movie_id);
  return $ok ? "Le film a été ajouté à vos favoris." : "Erreur lors de l'ajout aux favoris.";
}


function getFavoritesController(){
  $profile_id = $_REQUEST['profile_id'];
   return getFavorites($profile_id);  
}

function removeFavoriteController(){
  $profile_id = $_REQUEST['profile_id'];
  $movie_id = $_REQUEST['movie_id'];
  $ok = removeFavorites($profile_id, $movie_id);
  return $ok ? "Le film a été supprimé des favoris" : "Le film n'a pas pu être supprimé des favoris";
}

function getMomentMoviesController(){
  $MomentMovies = getMomentMovies();
  error_log("Films mis en avant récupérés : " . json_encode($MomentMovies)); // Ajoutez ce log
  return $MomentMovies ? $MomentMovies : [];
}