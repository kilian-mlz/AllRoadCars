<?php
// Vérifie si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure la connexion à la base de données
    require 'relier_bdd.php';
    session_start();
    global $conn;
    // Récupère les données du formulaire
    $name = $_POST['topic-name'];
    $description = $_POST['message'];
    $category = $_POST['topic-category'];
    $brand_topic = $_POST['topic-brand'];

    // Récupérer le nom d'utilisateur depuis la session
    $username = $_SESSION['user']['username']; // Assurez-vous de remplacer 'username' par la clé appropriée utilisée dans votre système d'authentification

    // Requête d'insertion dans la base de données avec le nom d'utilisateur associé à la session
    $sql = 'INSERT INTO topics (name, description, category, brand, user_name) VALUES (?, ?, ?, ?,?)';
    $stmt = $conn->prepare($sql);

    // Vérification si la préparation de la requête a réussi
    if ($stmt) {
        // Exécute la requête en liant les valeurs
        $stmt->execute([$name, $description, $category, $brand_topic, $username]);

        // Vérification si l'insertion a réussi
        if ($stmt->rowCount() > 0) {
            // Redirection vers la page d'accueil ou une autre page de confirmation
            header("Location: topic_list.php");
            exit();
        } else {
            // En cas d'échec de l'insertion, affichez un message d'erreur
            echo "Erreur: Impossible d'insérer le sujet.";
        }
    } else {
        // En cas d'échec de la préparation de la requête, affichez un message d'erreur
        echo "Erreur: Préparation de la requête a échoué.";
    }

    // Fermer la connexion à la base de données
    $conn = null;
}
?>
