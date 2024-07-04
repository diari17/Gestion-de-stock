<?php
// Exemple de récupération de l'email depuis la session (adaptez selon votre système d'authentification)
session_start();
$user_email = $_SESSION['user_email'];
$nom_utilisateur = $_SESSION['nom_utilisateur'];
$prenom_utilisateur = $_SESSION['prenom_utilisateur'];

// Si 'user_email' n'est pas défini, vous pouvez gérer cela pour éviter une erreur
if (!isset($user_email)) {
    // Redirection par exemple vers une page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Vendeur</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assurez-vous d'avoir un fichier styles.css pour la mise en page -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff; /* Fond blanc */
            color: #000; /* Texte noir */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .dashboard-container {
            background-color: #f0f0f0; /* Fond gris clair */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1000px;
        }

        .dashboard-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333; /* Texte gris foncé */
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
            color: #555; /* Texte gris */
        }

        .info-box {
            background-color: #fff; /* Fond blanc */
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .info-box h3 {
            color: #333; /* Texte gris foncé */
            margin-bottom: 10px;
        }

        .info-box p {
            color: #666; /* Texte gris moyen */
            margin-bottom: 5px;
        }

        .logout-link {
            text-align: center;
            margin-top: 20px;
        }

        .logout-link a {
            color: #007bff; /* Couleur bleue similaire à votre thème */
            text-decoration: none;
        }

        .logout-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Dashboard Vendeur</h2>
        <div class="welcome-message">
            <p>Bienvenue, <?php echo htmlspecialchars($prenom_utilisateur . ' ' . $nom_utilisateur); ?> !</p>
        </div>

        <!-- Liens vers les autres pages -->
        <div class="info-box">
            <h3><a href="produits_vendre.php" style="text-decoration:none; color:inherit;">Produits à Vendre</a></h3>
            <p>Liste de vos produits à vendre...</p>
        </div>

        <div class="info-box">
            <h3><a href="commandes_en_cours.php" style="text-decoration:none; color:inherit;">Commandes en Cours</a></h3>
            <p>Liste des commandes en cours...</p>
        </div>

        <div class="info-box">
            <h3><a href="gestion_stocks.php" style="text-decoration:none; color:inherit;">Gestion des Stocks</a></h3>
            <p>Gérer vos stocks...</p>
        </div>

        <!-- Lien de déconnexion -->
        <div class="logout-link">
            <p><a href="deconnexion.php">Déconnexion</a></p>
        </div>
    </div>
</body>
</html>
