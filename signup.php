<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <form action="signup.php" method="post" class="form register">
                <h2 class="text-center mb-4">Inscription</h2>
                <p class="text-center mb-4">Remplissez les informations pour vous inscrire.</p>
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input id="username" type="text" name="username" class="form-control" placeholder="Entrez un nom d'utilisateur" required>
                    <span class="error" id="usernameError"></span>
                </div>
                <div class="form-group">
                    <label for="psw-repeat">Email</label>
                    <input id="email" type="text" name="email" class="form-control" placeholder="Entrez un email valide" required>
                    <span class="error" id="emailError"></span>
                </div>
                <div class="form-group">
                    <label for="psw">Mot de passe</label>
                    <input id="psw" type="password" name="psw" class="form-control" placeholder="Entrez un mot de passe" required>
                    <span class="error" id="passwordError"></span>
                </div>
                <div class="form-group">
                    <label for="psw-repeat">Repéter le mot de passe</label>
                    <input id="psw-repeat" type="password" name="psw-repeat" class="form-control" placeholder="Repéter le mot de passe" required>
                    <span class="error" id="repeatPasswordError"></span>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Envoyer</button>
                <span class="error" id="formError"></span>
            </form>
            <p class="text-center mt-3">Déjà inscrit ? <a href="login.php">Se connecter</a></p>
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
include 'relier_bdd.php';
global $conn;
if(isset($_POST['username']) && !empty($_POST['username']) &&
    isset($_POST['psw']) && !empty($_POST['psw']) &&
    isset($_POST['psw-repeat']) && !empty($_POST['psw-repeat'])) {

    $username = $_POST['username'];
    $password = $_POST['psw'];
    $password_repeat = $_POST['psw-repeat'];
    $email = $_POST['email'];

    // Vérification du format du mot de passe
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('/[?&@#!*]/', $password);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 12) {
        // Afficher une erreur dans la modal
        echo "<script>
                document.getElementById('errorMessage').innerHTML = 'Le mot de passe doit contenir au moins 12 caractères et inclure des lettres majuscules et minuscules, des chiffres, ainsi qu\\'au moins un des caractères spéciaux suivants: ?&@#!*';
                showModal();
              </script>";
    } elseif($password !== $password_repeat) {
        // Afficher une erreur dans la modal
        echo "<script>
                document.getElementById('errorMessage').innerHTML = 'Les mots de passe ne correspondent pas';
                showModal();
              </script>";
    } else {
        // Hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql_select_user = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql_select_user);
        $stmt->execute(['username' => $_POST['username']]);
        $obj = $stmt->fetch();

        if ($obj === false) {
            $sql_insert_user = "INSERT INTO users (id, username, email, password, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_insert_user);
            $stmt->execute([NULL, $username, $email, $hashed_password, 0]);
            header('Location: login.php');
        } else {
            echo "<script>
                document.getElementById('errorMessage').innerHTML = `Ce nom d'utilisateur est déjà utilisé`;
                showModal();
              </script>";
        }
    }
}
?>
</body>
</html>
