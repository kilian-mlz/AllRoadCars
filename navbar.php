<header>
    <p class="pNavbar">AllRoadCar</p>
    <nav class="navbar">
        <div class="burger" onclick="toggleMenu()">
            <div class="barre"></div>
            <div class="barre"></div>
            <div class="barre"></div>
        </div>
        <div class="menu">
            <ul>
                <li>
                    <a href="index.php" class="nav-link">ACCUEIL</a>
                </li>
                <li>
                    <a href="category_list.php" class="nav-link">CATEGORIES</a>
                </li>
                <li>
                    <a href="topic_list.php" class="nav-link">SUJETS</a>
                </li>
                <?php
                if(isset($_SESSION['user']['id'])) {
                    // L'utilisateur est connecté, afficher le lien "Déconnecter"
                    echo '<li class="dropdown">
                          <a href="#" class="dropbtn nav-link">PROFIL</a>
                          <div class="dropdown-content">
                              <a class="nav-link" href="logout.php">Déconnecter</a>
                              <a class="nav-link" href="my_topics.php">Mes sujets</a>
                              <a id="deleteButton" class="nav-link" href="#">Supprimer</a>
                          </div>
                      </li>';
                } else {
                    // L'utilisateur n'est pas connecté, afficher le lien "Connexion"
                    echo '<li>
                          <a href="login.php" class="nav-link">CONNEXION</a>
                      </li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Voulez-vous vraiment supprimer votre profil ?</p>
        <button id="confirmDelete" class="btn-primary">Supprimer</button>
    </div>
</div>

<script>
    var modal = document.getElementById('myModal');
    var btn = document.getElementById("deleteButton");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Lorsque l'utilisateur clique sur le bouton "Supprimer" dans la modal
    document.getElementById("confirmDelete").onclick = function() {
        // Envoyer une requête AJAX pour supprimer l'utilisateur
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_user.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    window.location.href = "logout.php";
                } else {
                    alert("Une erreur s'est produite lors de la suppression de votre profil.");
                }
                modal.style.display = "none";
            }
        };
        xhr.send();
    };
</script>
<script src="navbar.js"></script>
