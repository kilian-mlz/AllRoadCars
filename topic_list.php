<?php
include 'relier_bdd.php';
session_start();
global $conn;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_topic'])) {
        if (isset($_SESSION['user'])) {
            $topic_id = $_POST['delete_topic'];
            $user_id = $_SESSION['user']['name'];

            $sql_check_owner = "SELECT user_name FROM topics WHERE id = :topic_id";
            $stmt_check_owner = $conn->prepare($sql_check_owner);
            $stmt_check_owner->bindValue(':topic_id', $topic_id);
            $stmt_check_owner->execute();
            $topic_owner = $stmt_check_owner->fetch(PDO::FETCH_ASSOC)['user_id'];

            if ($topic_owner == $user_id) {
                $sql_delete_topic = "DELETE FROM topics WHERE id = :topic_id";
                $stmt_delete_topic = $conn->prepare($sql_delete_topic);
                $stmt_delete_topic->bindValue(':topic_id', $topic_id);
                $stmt_delete_topic->execute();

                header("Location: topic_list.php");
                exit();
            } else {
                echo "<script>alert(`Vous n'avez pas la permission de supprimer ce sujet.`)</script>";
            }
        } else {
            echo "<script>alert('Vous devez être connecté pour supprimer un sujet.')</script>";
        }
    }
}

$sql = "SELECT topics.*, COUNT(DISTINCT comments.user_name) AS num_users_replied, COUNT(comments.id) AS num_comments, MAX(comments.created_at) AS last_comment_date
        FROM topics
        LEFT JOIN comments ON topics.id = comments.topic_id
        GROUP BY topics.id
        ORDER BY topics.created_at DESC
        LIMIT 15";
$stmt = $conn->query($sql);
$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_categories = "SELECT name FROM category";
$stmt_categories = $conn->query($sql_categories);
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

$sql_brands = "SELECT brand FROM vehicule";
$stmt_brands = $conn->query(($sql_brands));
$brands = $stmt_brands->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AllRoadCar - Sujets</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
<?php
include 'navbar.php';
?>
<div class="container">
    <h1 class="mt-5 mb-4">AllRoadCar - Derniers Sujets</h1>

    <div class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un sujet">
            <button class="btn btn-outline-primary" type="button" id="searchButton">Rechercher</button>
        </div>
        <?php
        if (isset($_SESSION['user'])) {
            $sql_count_topics = "SELECT COUNT(*) AS num_topics FROM topics WHERE user_name = :user_name";
            $stmt_count_topics = $conn->prepare($sql_count_topics);
            $stmt_count_topics->bindValue(':user_name', $_SESSION['user']['username']);
            $stmt_count_topics->execute();
            $num_topics = $stmt_count_topics->fetch(PDO::FETCH_ASSOC)['num_topics'];

            $max_topics = 10;

            if ($num_topics < $max_topics) {
                echo '<button class="btn btn-primary" onclick="openCreateModal()">Créer un nouveau sujet</button>';
            } else {
                echo '<p class="limitSubject">Vous avez atteint la limite de sujets autorisés. Supprimez un sujet pour pouvoir en créer un nouveau</p>';
            }
        }
        ?>
    </div>

    <div id="create-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCreateModal()">&times;</span>
            <h2>Création d'un sujet de discussion</h2>
            <form id="create-topic-form" action="create_topic.php" method="POST">
                <div class="info-topic">
                    <div class="name">
                        <label for="topic-name" >Nom du sujet:</label>
                        <input type="text" id="topic-name" name="topic-name" class="form-control" required>
                    </div>
                    <div class="category">
                        <label class="form-label mb-0">Catégorie</label>
                        <select class="form-select " aria-label="Default select example" name="topic-category">
                            <option selected>Voir les catégories</option>
                            <?php foreach ($categories as $category):?>
                                <option value="<?=$category['name'];?>"><?=$category['name'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="brand">
                        <label class="form-label mb-0">Marque</label>
                        <select class="form-select " aria-label="Default select example" name="topic-brand">
                            <option selected>Voir les marques</option>
                            <?php foreach ($brands as $brand):?>
                                <option value="<?=$brand['brand'];?>"><?=$brand['brand'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Votre message </label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Description de votre message" name="message"></textarea>
                </div>
                <button class="btn btn-success" type="submit">Create</button>
            </form>
        </div>
    </div>

    <ul class="list-group">
        <?php foreach ($topics as $topic): ?>
            <li class="list-group-item">
                <a href="redirect.php?id=<?= $topic['id']; ?>" class="text-decoration-none"><?= htmlspecialchars($topic['name']); ?></a>
                <span class="badge bg-secondary"><?= $topic['num_users_replied']; ?> utilisateurs ont répondu</span>
                <span class="badge bg-secondary"><?= $topic['num_comments']; ?> réponses</span>
                <span class="badge bg-secondary"><?= date('d/m/Y', strtotime($topic['created_at'])); ?></span>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['username'] == $topic['user_name']): ?>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="delete_topic" value="<?= $topic['id']; ?>">
                        <button type="submit" class="btn btn-secondary">Supprimer</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script src="script.js"></script>
<script>
    document.getElementById("searchButton").addEventListener("click", function() {
        var searchInput = document.getElementById("searchInput").value.trim();
        if (searchInput !== "") {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "check_topic.php?search=" + encodeURIComponent(searchInput), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.exists) {
                            window.location.href = "discussion.php?id=" + response.topicId;
                        } else {
                            alert("Le sujet n'a pas été trouvé.");
                        }
                    } else {
                        alert("Une erreur s'est produite lors de la recherche du sujet.");
                    }
                }
            };
            xhr.send();
        } else {
            alert("Veuillez entrer un sujet à rechercher.");
        }
    });
</script>
</body>
</html>
