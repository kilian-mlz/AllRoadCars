<?php
// Inclure la connexion à la base de données
include 'relier_bdd.php';
global $conn;
session_start();

// Vérifier si l'identifiant de l'utilisateur à supprimer est défini
if(isset($_SESSION['user']['username'])) {
    $user_name = $_SESSION['user']['username'];

    // Requête pour supprimer les sujets de l'utilisateur
    $sql_delete_topics = "DELETE FROM topics WHERE user_name = :user_name";
    $stmt_delete_topics = $conn->prepare($sql_delete_topics);
    $stmt_delete_topics->bindParam(":user_name", $user_name);
    $stmt_delete_topics->execute();

    // Requête pour supprimer l'utilisateur et ses données associées
    $sql_delete_user = "DELETE FROM users WHERE id = :id";
    $stmt_delete_user = $conn->prepare($sql_delete_user);
    $stmt_delete_user->bindParam(":id", $user_id);
    $stmt_delete_user->execute();

    // Fermer la session pour déconnecter l'utilisateur
    session_unset();
    session_destroy();

    // Réponse AJAX
    http_response_code(200);
    header('Location: login.php');
} else {
    // Réponse AJAX en cas d'erreur
    http_response_code(400);
    echo json_encode(array("message" => "L'identifiant de l'utilisateur n'est pas spécifié."));
}
?>
