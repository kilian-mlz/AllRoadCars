<?php
include 'relier_bdd.php';
session_start();
global $conn;
if(isset($_GET['category'])) {
    $category_name = $_GET['category'];

    $sql = "SELECT * FROM topics WHERE category = :category";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category', $category_name);
    $stmt->execute();
    $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: categories.php");
    exit();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AllRoadCar - <?= htmlspecialchars($category_name); ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1 class="mt-5 mb-4">AllRoadCar - <?= htmlspecialchars($category_name); ?></h1>

    <ul class="list-group">
        <?php foreach ($topics as $topic): ?>
            <li class="list-group-item">
                <a href="redirect.php?id=<?= $topic['id']; ?>" class="text-decoration-none"><?= htmlspecialchars($topic['name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script src="script.js"></script>
</body>
</html>
