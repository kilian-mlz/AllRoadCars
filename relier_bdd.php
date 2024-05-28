<?php
$servername = "localhost"; // Adresse du serveur MySQL
$username = "john"; // Nom d'utilisateur de la base de données
$password = "password123"; // Mot de passe de la base de données
$dbname = "blog"; // Nom de la base de données

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Échec de la connexion à la base de données: " . $e->getMessage());
}
?>
