<?php
$mysqli = new mysqli('localhost', 'root', '', 'livreor');

if ($mysqli->connect_error) {
    die('Erreur de connexion : ' . $mysqli->connect_error);
}

session_start();

$message = "";

if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['password2'])) {

    $login = $_POST['login'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password !== $password2) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si le login existe déjà
        $stmt = $mysqli->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $message = "Ce login existe déjà.";
            $stmt->close();
        } else {
            $stmt->close();
            
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $mysqli->prepare("INSERT INTO utilisateurs (login, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $login, $password_hash);
            $stmt->execute();
            $stmt->close();

            header("Location: connexion.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
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
    <a href="connexion.php">Connexion</a>
</nav>

<h2>Inscription</h2>

<?php if (!empty($message)): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Login</label>
    <input type="text" name="login" required>

    <label>Mot de passe</label>
    <input type="password" name="password" required>

    <label>Confirmation du mot de passe</label>
    <input type="password" name="password2" required>

    <button type="submit">S'inscrire</button>
</form>

</body>
</html>
