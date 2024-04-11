<?php
require "relier_bdd.php";
session_start();

$sql = "SELECT * FROM topics ORDER BY id DESC LIMIT 3";
global $conn;

$stmt = $conn->query($sql);

$topics = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Faire un site optimisé SEO">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="styles.css">
    <script src="bootstrap/js/bootstrap.js"></script>
    <title>AllRoadCar - Homepage</title>
</head>
<body>
<?php
include 'navbar.php';
?>
<div class="bgImg">
    <div class="presentation">
        <h1>Bienvenue sur AllRoadCar</h1>
    </div>
</div>
<div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="carousel-caption">
                <h5>Décrouvrez les 3 derniers sujets qui viennent d'être ouverts.</h5>
                <div class="in_slider">
                    <ul>
                        <li>
                            <h6>UNE QUESTION? <br> UNE CONVERSATION!</h6>
                        </li>
                        <li>
                            <h6>ENTOURÉ <br> DE SPÉCIALISTES DE <br> L'AUTOMOBILE</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php foreach($topics as $topic):?>
            <div class="carousel-item">
                <div class="carousel-caption">
                    <a href="redirect.php?id=<?= $topic['id']; ?>"> <h5><?= $topic['name']?></h5> </a>
                    <div class="descriptionLastArticle">
                        <a href="redirect.php?id=<?= $topic['id']; ?>"><p><?= $topic['description']?></p></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
</body>