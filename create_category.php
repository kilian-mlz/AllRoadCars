<?php
// Vérifie si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure la connexion à la base de données
    require 'relier_bdd.php';
    global $conn;
    // Récupère les données du formulaire
    $name = $_POST['category-name'];

    // Requête d'insertion dans la base de données
    $sql = 'INSERT INTO category (name) VALUES (?)';
    $stmt = $conn->prepare($sql);

    // Vérification si la préparation de la requête a réussi
    if ($stmt) {
        // Exécute la requête en liant les valeurs
        $stmt->execute([$name]);

        // Vérification si l'insertion a réussi
        if ($stmt->rowCount() > 0) {
            // Redirection vers la page de la liste des catégories ou une autre page de confirmation
            header("Location: category_list.php");
            exit();
        } else {
            // En cas d'échec de l'insertion, affichez un message d'erreur
            echo "Erreur: Impossible d'insérer la catégorie.";
        }
    } else {
        // En cas d'échec de la préparation de la requête, affichez un message d'erreur
        echo "Erreur: Préparation de la requête a échoué.";
    }

    // Fermer la connexion à la base de données
    $conn = null;
}
?>
