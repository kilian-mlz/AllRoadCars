<?php
require 'relier_bdd.php';
global $conn;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <form action="login.php" method="POST" class="form login">
                <h2 class="text-center mb-4">Connexion</h2>
                <div class="form-group">
                    <label for="login__username">Nom d'utilisateur</label>
                    <input id="login__username" type="text" name="username" class="form-control" placeholder="Entrez votre nom d'utilisateur" required>
                </div>
                <div class="form-group">
                    <label for="login__password">Mot de passe</label>
                    <input id="login__password" type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>
            <p class="text-center mt-3">Pas de compte ? <a href="signup.php">S'inscrire</a></p>
        </div>
    </div>
</div>
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Erreur</h5>
            </div>
            <div class="modal-body">
                <p id="errorMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Fermer</button>
            </div>
        </div>
    </div>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>

<script>
    function showModal() {
        document.getElementById('errorModal').classList.add('show');
        document.getElementById('errorModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('errorModal').classList.remove('show');
        document.getElementById('errorModal').style.display = 'none';
    }
</script>

<?php
if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password'])) {
    $sql_select_user = "SELECT id, status, password FROM users WHERE username = :username || email = :username";
    $stmt = $conn->prepare($sql_select_user);
    $stmt->execute(['username' => $_POST['username'], 'email' => $_POST['username']]);
    $user = $stmt->fetch();

    if($user !== false && $user['status'] !== null && password_verify($_POST['password'], $user['password'])) {
        session_start();
        $_SESSION['auth'] = true;
        $_SESSION['user']['username'] = $_POST['username'];
        $_SESSION['user']['status'] = $user['status'];
        $_SESSION['user']['id'] = $user['id'];
        header('Location: index.php');
    }else{
        echo "<script>
                document.getElementById('errorMessage').innerHTML = `Il y a une erreur dans le nom d'utilisateur ou dans le mot de passe`;
                showModal();
              </script>";
    }
}

?>

</body>
</html>
