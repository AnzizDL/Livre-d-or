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

if (!empty($_POST['commentaire'])) {
    $commentaire = $_POST['commentaire'];
    $id_utilisateur = $_SESSION['id'];
    $date = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $commentaire, $id_utilisateur, $date);
    $stmt->execute();
    $stmt->close();

    header("Location: livre-or.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un commentaire</title>
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
            max-width: 600px;
            gap: 8px;
            margin-top: 20px;
        }
        textarea {
            padding: 8px;
            min-height: 150px;
        }
        button {
            padding: 8px;
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Accueil</a>
    <a href="livre-or.php">Livre d'or</a>
    <a href="profil.php">Profil</a>
    <?php if (isset($_SESSION['login'])): ?>
        <span>Connecté en tant que <?= htmlspecialchars($_SESSION['login']) ?></span>
        <a href="deconnexion.php">Déconnexion</a>
    <?php endif; ?>
</nav>

<h2>Ajouter un commentaire</h2>

<form method="POST">
    <label>Votre commentaire</label>
    <textarea name="commentaire" required></textarea>

    <button type="submit">Poster</button>
</form>

</body>
</html>
