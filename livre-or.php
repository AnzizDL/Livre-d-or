<?php
$mysqli = new mysqli('localhost', 'root', '', 'livreor');

if ($mysqli->connect_error) {
    die('Erreur de connexion : ' . $mysqli->connect_error);
}

session_start();

$sql = "
    SELECT commentaires.commentaire, commentaires.date, utilisateurs.login
    FROM commentaires
    INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id
    ORDER BY commentaires.date DESC
";

$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d’or</title>
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
        .comment {
            margin-bottom: 15px;
        }
        .comment p {
            margin: 5px 0;
        }
        hr {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Accueil</a>
    <a href="livre-or.php">Livre d'or</a>
    <?php if (!isset($_SESSION['login'])): ?>
        <a href="inscription.php">Inscription</a>
        <a href="connexion.php">Connexion</a>
    <?php else: ?>
        <a href="profil.php">Profil</a>
        <span>Connecté en tant que <?= htmlspecialchars($_SESSION['login']) ?></span>
        <a href="deconnexion.php">Déconnexion</a>
    <?php endif; ?>
</nav>

<h2>Livre d’or</h2>

<?php if (isset($_SESSION['id'])): ?>
    <p><a href="commentaire.php">Ajouter un commentaire</a></p>
<?php endif; ?>

<?php while ($row = $result->fetch_assoc()): ?>
    <div class="comment">
        <p><strong>posté le <?= date('d/m/Y', strtotime($row['date'])) ?> par <?= htmlspecialchars($row['login']) ?></strong></p>
        <p><?= nl2br(htmlspecialchars($row['commentaire'])) ?></p>
        <hr>
    </div>
<?php endwhile; ?>

</body>
</html>
