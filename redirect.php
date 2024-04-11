<?php
session_start();

if(isset($_SESSION['user']['id'])) {
    // L'utilisateur est connecté, redirigez vers la page de discussion
    header("Location: discussion.php?id=" . $_GET['id']);
    exit();
} else {
    // L'utilisateur n'est pas connecté, redirigez vers la page de connexion
    header("Location: logout.php");
    exit();
}
?>
