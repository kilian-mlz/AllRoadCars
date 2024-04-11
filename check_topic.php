<?php
// Inclure la connexion à la base de données
include 'relier_bdd.php';
session_start();
global $conn;
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: topic_list.php');
    exit();
}

// Vérifier si la méthode de requête est GET et si le paramètre de recherche est défini
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    // Récupérer le terme de recherche depuis la requête GET et nettoyer les données entrantes
    $searchTerm = trim($_GET['search']);

    // Vérifier si le terme de recherche n'est pas vide
    if (!empty($searchTerm)) {
        // Préparer le terme de recherche avec des wildcards pour correspondre à des termes partiels
        $searchTerm = '%' . $searchTerm . '%';

        // Requête pour rechercher les sujets correspondant au terme de recherche dans la base de données
        $sql_search = "SELECT id FROM topics WHERE name LIKE :searchTerm";
        $stmt_search = $conn->prepare($sql_search);
        $stmt_search->bindParam(':searchTerm', $searchTerm);
        $stmt_search->execute();
        $result = $stmt_search->fetch(PDO::FETCH_ASSOC);

        // Préparer la réponse JSON
        $response = array();

        if ($result) {
            // Le sujet a été trouvé
            $response['exists'] = true;
            $response['topicId'] = $result['id'];
        } else {
            // Le sujet n'a pas été trouvé
            $response['exists'] = false;
        }

        // Envoyer la réponse JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Si le terme de recherche est vide, renvoyer une erreur
        http_response_code(400);
        echo "Erreur: Terme de recherche vide.";
    }
} else {
    // Si la méthode de requête n'est pas GET ou si le paramètre de recherche n'est pas défini, renvoyer une erreur
    http_response_code(400);
    echo "Erreur: Requête invalide.";
}
?>
