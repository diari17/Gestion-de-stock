<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";  // Utilisateur par défaut de MySQL
    $password = "";  // Mot de passe par défaut de MySQL
    $dbname = "gestion_stock";

    // Créer une connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $telephone = $_POST['telephone'];
    $role = 'acheteur';  // Par défaut, l'utilisateur s'inscrit en tant qu'acheteur

    // Préparer et exécuter la requête SQL pour insérer l'utilisateur dans la base de données
    $sql = "INSERT INTO utilisateurs (nom_utilisateur, prenom_utilisateur, email, mot_de_passe, telephone, role) 
            VALUES ('$nom', '$prenom', '$email', '$password', '$telephone', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvel enregistrement créé avec succès";
        // Rediriger vers une page de confirmation ou une autre page après l'inscription
        header("Location: connexion.php");
        exit();
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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

        .form-container {
            background-color: #f0f0f0; /* Fond gris clair */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333; /* Texte gris foncé */
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left; /* Alignement du texte à gauche */
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333; /* Texte gris foncé */
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Pour inclure le padding et la bordure dans la largeur */
        }

        .form-group span {
            color: red;
            font-size: 14px;
        }

        button {
            background-color: #333; /* Fond gris foncé */
            color: #fff; /* Texte blanc */
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            width: 100%; /* Ajuster la largeur du bouton */
            margin-top: 10px; /* Espacement au-dessus du bouton */
        }

        button:hover {
            background-color: #555; /* Fond gris légèrement plus foncé au survol */
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-link a {
            color: #007bff; /* Couleur bleue similaire à votre thème */
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Inscription</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" required>
            </div>

            <button type="submit">S'inscrire</button>
        </form>

        <div class="login-link">
            <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous ici</a></p>
        </div>
    </div>
</body>
</html>