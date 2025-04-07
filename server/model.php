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
define("DBNAME", "vialatou2");
define("DBLOGIN", "vialatou2");
define("DBPWD", "vialatou2");

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