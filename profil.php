<?php
$mysqli = new mysqli('localhost', 'root', '', 'livreor');

if ($mysqli->connect_error) {
    die('Erreur de connexion : ' . $mysqli->connect_error);
}

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit;
}

$message = "";

if (!empty($_POST['login']) && !empty($_POST['password'])) {

    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $id = $_SESSION['id'];

    $stmt = $mysqli->prepare("UPDATE utilisateurs SET login = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $login, $password_hash, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['login'] = $login;
    $message = "Profil mis à jour.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
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
            color: green;
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Accueil</a>
    <a href="livre-or.php">Livre d'or</a>
    <?php if (isset($_SESSION['login'])): ?>
        <span>Connecté en tant que <?= htmlspecialchars($_SESSION['login']) ?></span>
        <a href="deconnexion.php">Déconnexion</a>
    <?php endif; ?>
</nav>

<h2>Modifier mon profil</h2>

<?php if (!empty($message)): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nouveau login</label>
    <input type="text" name="login" value="<?= htmlspecialchars($_SESSION['login']) ?>" required>

    <label>Nouveau mot de passe</label>
    <input type="password" name="password" required>

    <button type="submit">Mettre à jour</button>
</form>

</body>
</html>
