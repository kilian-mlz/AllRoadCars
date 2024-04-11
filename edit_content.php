<?php
session_start();
include 'relier_bdd.php';
global $conn;
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si l'identifiant du commentaire est défini dans l'URL
if (isset($_GET['id'])) {
    $comment_id = $_GET['id'];

    // Requête pour récupérer le commentaire depuis la base de données
    $sql = "SELECT * FROM comments WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $comment_id);
    $stmt->execute();
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le commentaire existe et si l'utilisateur est l'auteur du commentaire
    if ($comment && $_SESSION['user']['username'] == $comment['user_name']) {
        // Traitement de la modification du commentaire
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_content = $_POST['content'];

            // Mettre à jour le commentaire dans la base de données
            $sql_update = "UPDATE comments SET content = :content WHERE id = :id";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bindParam(":content", $new_content);
            $stmt_update->bindParam(":id", $comment_id);
            $stmt_update->execute();

            header("Location: discussion.php?id=" . $comment['topic_id']);
            exit();
        }
    } else {
        // Rediriger l'utilisateur si le commentaire n'existe pas ou s'il n'est pas l'auteur du commentaire
        header("Location: error.php");
        exit();
    }
} else {
    // Rediriger l'utilisateur si l'identifiant du commentaire n'est pas défini dans l'URL
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le commentaire</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
<div class="modify">
    <h1>Modifier le commentaire</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $comment_id); ?>" method="post">
        <textarea name="content" rows="4" cols="50"><?php echo htmlspecialchars($comment['content']); ?></textarea><br>
        <input type="submit" value="Enregistrer">
    </form>
</div>

</body>
</html>
