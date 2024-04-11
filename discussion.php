<?php
// Inclure la connexion à la base de données
include 'relier_bdd.php';
session_start();
global $conn;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AllRoadCar - Discussions</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<article>

    <?php

    // Vérifier si l'identifiant du sujet est défini dans l'URL
    if(isset($_GET['id'])) {
        $topic_id = $_GET['id'];

        // Requête pour récupérer les informations sur le sujet, y compris le nom de l'utilisateur qui l'a créé
        $sql_topic = "SELECT topics.*, users.username AS creator_username 
              FROM topics 
              JOIN users ON topics.user_name = users.username
              WHERE topics.id = :id";

        $stmt_topic = $conn->prepare($sql_topic);
        $stmt_topic->bindParam(":id", $topic_id);
        $stmt_topic->execute();
        $topic = $stmt_topic->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le sujet existe
        if ($topic) {
            // Afficher les informations sur le sujet
            echo "<h1>" . htmlspecialchars($topic['name']) . "</h1>";
            echo "<h5> Marque : " . htmlspecialchars($topic['brand']) . "</h5>";
            echo "<h5>" . htmlspecialchars($topic['description']) . "</h5>";
            echo "<h6 class='creePar'> Crée par : " . htmlspecialchars($topic['creator_username']) . "</h6>";

            // Requête pour récupérer les messages associés à ce sujet
            $sql_messages = "SELECT * FROM comments WHERE topic_id = :topic_id ORDER BY created_at DESC";
            $stmt_messages = $conn->prepare($sql_messages);
            $stmt_messages->bindParam(":topic_id", $topic_id);
            $stmt_messages->execute();
            $messages = $stmt_messages->fetchAll(PDO::FETCH_ASSOC);

            // Vérifier si des messages existent
            if ($messages) {
                // Afficher les messages
                echo "<div class='messages'>";
                foreach ($messages as $message) {
                    echo "<div class='message'>";
                    echo "<p>Posté par : " . htmlspecialchars($message['user_name']) . " à " . htmlspecialchars($message['created_at']) . "</p>";
                    echo "<p>" . htmlspecialchars($message['content']) . "</p>";

                    // Ajouter des liens pour modifier et supprimer le message si l'utilisateur est connecté et si le message lui appartient
                    if(isset($_SESSION['user']) && $_SESSION['user']['username'] == $message['user_name']) {
                        echo "<a href='edit_content.php?id=" . $message['id'] . "'>Modifier</a> | ";
                        echo "<a href='delete_content.php?id=" . $message['id'] . "'>Supprimer</a>";
                    }

                    echo "</div>";
                }
                echo "</div>";

            } else {
                echo "<p>Aucun message n'a été trouvé pour ce sujet.</p>";
            }
            // Formulaire d'ajout de message
            echo "<form action='add_comment.php' method='POST'>";
            echo "<input type='hidden' name='topic_id' value='$topic_id'>";
            echo "<textarea name='content' rows='4' cols='50' placeholder='Tapez votre commentaire'></textarea><br>";
            echo "<input type='submit' value='Répondre'>";
            echo "</form>";
        }
    }

    ?>

</article>
</body>
</html>
