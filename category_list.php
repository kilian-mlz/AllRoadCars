<?php
// Inclure la connexion à la base de données
include 'relier_bdd.php';
session_start();
global $conn;
// Vérifier si l'utilisateur est administrateur
if(isset($_SESSION['user']) && $_SESSION['user']['status'] == 1) {
    $is_admin = true;
} else {
    $is_admin = false;
}

// Requête pour récupérer toutes les catégories depuis la base de données
$sql = "SELECT * FROM category";
$stmt = $conn->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fermer la connexion à la base de données
$stmt = null;
$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AllRoadCar - Categories</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
<?php
include 'navbar.php';
?>
<div class="container">
    <h1 class="mt-5 mb-4">AllRoadCar - Categories</h1>

    <?php if($is_admin): ?>
        <div class="mb-3">
            <button class="btn btn-primary" onclick="openCreateModal()">Crée une nouvelle categorie</button>
        </div>
    <?php endif; ?>

    <div id="create-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCreateModal()">&times;</span>
            <h2>Création d'une catégorie</h2>
            <!-- Formulaire de création de catégorie -->
            <form id="create-category-form" action="create_category.php" method="POST">
                <div class="name">
                    <label for="category-name">Nom de la catégorie:</label>
                    <input type="text" id="category-name" name="category-name" class="form-control" required>
                </div>
                <button class="btn btn-success" type="submit">Create</button>
            </form>
        </div>
    </div>

    <ul class="list-group">
        <?php foreach ($categories as $category): ?>
            <li class="list-group-item">
                <a href="category.php?category=<?= urlencode($category['name']); ?>" class="text-decoration-none"><?= htmlspecialchars($category['name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script src="script.js"></script>
</body>
</html>
