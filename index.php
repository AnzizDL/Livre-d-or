<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d'or - Accueil</title>
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
        footer {
            margin-top: 40px;
            font-size: 0.9em;
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

<h1>Bienvenue sur le Livre d’or</h1>
<p>Ce site permet aux utilisateurs inscrits de laisser leurs avis.</p>

<footer>
    <p>Repo GitHub : 
        <a href="https://github.com/prenom-nom/livre-or" target="_blank">
            https://github.com/prenom-nom/livre-or
        </a>
    </p>
</footer>

</body>
</html>
