<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "SAE203");
define("DBLOGIN", "vialatou2");
define("DBPWD", "090405");



function getAllMovies(){
    $snx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id,name, image FROM Movie";
    $stmt = $snx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $res;
}

function addMovie($name, $director, $year, $length, $description,$id_category, $image, $trailer, $min_age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $sql = "INSERT INTO Movie (name, director, year, length, description, id_category, image, trailer, min_age) 
            VALUES (:name, :director, :year, :length, :description, :id_category, :image, :trailer, :min_age)";

    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':director', $director);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':length', $length);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id_category', $id_category);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':trailer', $trailer);
    $stmt->bindParam(':min_age', $min_age);

    $stmt->execute();
    $res = $stmt->rowCount();
    return $res; // Retourne le nombre de lignes affectées par l'opération
}

function getMovieDetail($id) {

    try {
        
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        
        $sql = "SELECT 
                    Movie.id, 
                    Movie.name, 
                    Movie.director, 
                    Movie.year, 
                    Movie.length, 
                    Movie.description, 
                    Movie.image, 
                    Movie.trailer, 
                    Movie.min_age, 
                    Movie.id_category, 
                    Category.name AS category
                FROM Movie
                JOIN Category ON Movie.id_category = Category.id
                WHERE Movie.id = :id";

        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        
        $movieDetail = $stmt->fetch(PDO::FETCH_OBJ);

        return $movieDetail; 
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage()); 
        return false;
    }

}

function getAllCategories() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT name FROM Category";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $res;
}

function getMoviesByCategory ($age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Requête SQL pour récupérer les films groupés par catégorie
    $sql = "SELECT 
                Category.id AS category_id, 
                Category.name AS category_name, 
                Movie.id AS movie_id, 
                Movie.name AS movie_name, 
                Movie.image AS movie_image
            FROM Movie
            JOIN Category ON Movie.id_category = Category.id
            WHERE Movie.min_age <= :age
            ORDER BY Category.name, Movie.name";

    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Regrouper les films par catégorie
    $categories = [];
    foreach ($rows as $row) {
        $categories[$row['category_id']]['name'] = $row['category_name'];
        $categories[$row['category_id']]['movies'][] = [
            "id" => $row['movie_id'],
            "name" => $row['movie_name'],
            "image" => $row['movie_image']
        ];
    }

    return array_values($categories); // Retourne un tableau indexé
}

function addProfile($id, $name, $avatar, $min_age) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $sql = "INSERT INTO Profile (id, name, avatar, min_age)
VALUES (:id, :name, :avatar, :min_age)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    avatar = VALUES(avatar),
    min_age = VALUES(min_age)";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
    $stmt->bindParam(':min_age', $min_age, PDO::PARAM_INT);

    error_log("Executing SQL: $sql with id=$id, name=$name, avatar=$avatar, min_age=$min_age");

    $stmt->execute();
    $res = $stmt->rowCount(); 
    return $res; 
}

function getAllProfile() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $sql = "SELECT id, name, avatar, min_age FROM Profile";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function addFavorites( $profile_id, $movie_id){
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Favorites (profile_id, movie_id) 
            VALUES (:profile_id, :movie_id)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}

function getFavorites($profile_id){
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.id, Movie.name, Movie.image 
            FROM Favorites 
            JOIN Movie ON Favorites.movie_id = Movie.id 
            WHERE Favorites.profile_id = :profile_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isFavorite($profile_id, $movie_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT COUNT(*) FROM Favorites WHERE profile_id = :profile_id AND movie_id = :movie_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function removeFavorites ( $profile_id, $movie_id){
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $sql = "DELETE FROM Favorites WHERE profile_id = :profile_id AND movie_id = :movie_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    $rowCount = $stmt->rowCount();

    // Log pour vérifier le résultat
    error_log("Suppression de favori : profile_id=$profile_id, movie_id=$movie_id, lignes affectées=$rowCount");

    return $rowCount;

}

function getMomentMovies() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, image, description FROM Movie WHERE is_Moment = TRUE";
    $stmt = $cnx->query($sql);
    $movies = $stmt->fetchAll(PDO::FETCH_OBJ);
    error_log("Films mis en avant récupérés : " . json_encode($movies)); // Ajoutez ce log
    return $movies;
}