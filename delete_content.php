<?php
session_start();
include 'relier_bdd.php';
global $conn;
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si l'identifiant du commentaire est défini dans l'URL et s'il est numérique
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $comment_id = $_GET['id'];

    // Requête préparée pour récupérer le commentaire depuis la base de données
    $sql = "SELECT * FROM comments WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $comment_id);
    $stmt->execute();
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le commentaire existe et si l'utilisateur est l'auteur du commentaire
    if ($comment && $_SESSION['user']['username'] == $comment['user_name']) {
        // Requête préparée pour supprimer le commentaire de la base de données
        $sql_delete = "DELETE FROM comments WHERE id = :id";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bindParam(":id", $comment_id);
        $stmt_delete->execute();

        // Rediriger l'utilisateur vers la page de discussion après la suppression
        header("Location: discussion.php?id=" . $comment['topic_id']);
        exit();
    } else {
        // Rediriger l'utilisateur si le commentaire n'existe pas ou s'il n'est pas l'auteur du commentaire
        header("Location: error.php");
        exit();
    }
} else {
    // Rediriger l'utilisateur si l'identifiant du commentaire n'est pas défini dans l'URL ou s'il n'est pas numérique
    header("Location: error.php");
    exit();
}
?>
