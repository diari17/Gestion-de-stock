<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stock";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Rechercher l'utilisateur par email
    $sql = "SELECT id, mot_de_passe, role FROM utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Vérifier le mot de passe
        if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Définir la variable de session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Rediriger l'utilisateur vers la page des produits à vendre
            header('Location: produits_vendre.php');
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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

        .form-group input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Pour inclure le padding et la bordure dans la largeur */
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

        .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .register-link a {
            color: #007bff; /* Couleur bleue similaire à votre thème */
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Connexion</h2>
        <form action="process_connexion.php" method="post">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <button type="submit">Se connecter</button>
        </form>

        <div class="register-link">
            <p>Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a></p>
        </div>
    </div>
</body>
</html>
