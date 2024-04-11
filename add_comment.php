<?php
include 'relier_bdd.php';
session_start();
global $conn;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['topic_id']) && isset($_POST['content'])) {
    $topic_id = $_POST['topic_id'];
    $content = $_POST['content'];

    if (!empty($content) && isset($_SESSION['user'])) {
        $user_name = $_SESSION['user']['username'];

        $sql = "INSERT INTO comments (topic_id, content, user_name) VALUES (:topic_id, :content, :user_name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":topic_id", $topic_id);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":user_name", $user_name);

        if ($stmt->execute()) {
            header("Location: discussion.php?id=$topic_id");
            exit;
        } else {
            echo "Une erreur s'est produite lors de l'ajout du commentaire.";
        }
    } else {
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
