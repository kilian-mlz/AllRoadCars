<?php
// Inclure la connexion à la base de données
include 'relier_bdd.php';
session_start();
global $conn;
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    // Rediriger vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit();
}

// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_topic'])) {
        // Récupérer l'ID du sujet à supprimer depuis le formulaire
        $topic_id = $_POST['delete_topic'];

        // Requête pour supprimer le sujet de la base de données
        $sql_delete_topic = "DELETE FROM topics WHERE id = :topic_id";
        $stmt_delete_topic = $conn->prepare($sql_delete_topic);
        $stmt_delete_topic->bindValue(':topic_id', $topic_id);
        $stmt_delete_topic->execute();

        // Rediriger l'utilisateur vers la page des sujets après la suppression
        header("Location: my_topics.php");
        exit();
    }
}

// Récupérer l'ID de l'utilisateur connecté
$user_name = $_SESSION['user']['username'];

// Requête pour récupérer les sujets créés par l'utilisateur
$sql = "SELECT * FROM topics WHERE user_name = :user_name ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':user_name', $user_name);
$stmt->execute();
$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fermer la connexion à la base de données
$stmt = null;
$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Topics</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
<?php
include 'navbar.php';
?>

<div class="container">
    <h1 class="mt-5 mb-4">Mes Sujets</h1>

    <ul class="list-group">
        <?php foreach ($topics as $topic): ?>
            <li class="list-group-item">
                <a href="redirect.php?id=<?= $topic['id']; ?>" class="text-decoration-none"><?= htmlspecialchars($topic['name']); ?></a>
                <span class="badge bg-secondary"><?= date('d/m/Y', strtotime($topic['created_at'])); ?></span>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="delete_topic" value="<?= $topic['id']; ?>">
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sujet ?');">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
