<?php
$mysqli = new mysqli('localhost', 'root', '', 'livreor');

if ($mysqli->connect_error) {
    die('Erreur de connexion : ' . $mysqli->connect_error);
}

session_start();

$message = "";

if (!empty($_POST['login']) && !empty($_POST['password'])) {

    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT * FROM utilisateurs WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            header("Location: index.php");
            exit;
        }
    }

    $message = "Identifiants incorrects.";
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
        }
        nav a {
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }
        form {
            display: flex;
            flex-direction: column;
            max-width: 300px;
            gap: 8px;
            margin-top: 20px;
        }
        input, button {
            padding: 8px;
        }
        .message {
            color: red;
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Accueil</a>
    <a href="livre-or.php">Livre d'or</a>
    <a href="inscription.php">Inscription</a>
</nav>

<h2>Connexion</h2>

<?php if (!empty($message)): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Login</label>
    <input type="text" name="login" required>

    <label>Mot de passe</label>
    <input type="password" name="password" required>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>
