<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stock";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si les données POST existent et sont non vides
if (isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];

    // Préparer votre requête SQL pour vérifier si l'email existe
    $sql_check_email = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    if ($result_check_email->num_rows > 0) {
        // L'email existe, vérifier le mot de passe
        $user_data = $result_check_email->fetch_assoc();
        if (password_verify($password, $user_data['mot_de_passe'])) {
            // Mot de passe correct, déterminer le rôle et rediriger
            $_SESSION['user_email'] = $user_data['email'];
            $_SESSION['nom_utilisateur'] = $user_data['nom_utilisateur']; // Ajouter le nom à la session
            $_SESSION['prenom_utilisateur'] = $user_data['prenom_utilisateur']; // Ajouter le prénom à la session
            
            // Vérifier le rôle et rediriger vers le tableau de bord approprié
            if ($user_data['role'] == 'vendeur') {
                header("Location: dashboard_vendeur.php");
            } elseif ($user_data['role'] == 'acheteur') {
                header("Location: dashboard_acheteur.php");
            } elseif ($user_data['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                // Gérer d'autres rôles ici si nécessaire
                // Par défaut, rediriger vers la page de connexion
                header("Location: connexion.php");
            }
            exit();
        } else {
            // Mot de passe incorrect, afficher un message d'erreur
            $_SESSION['login_error'] = "Mot de passe incorrect.";
            header("Location: connexion.php"); // Redirigez vers la page de connexion
            exit();
        }
    } else {
        // Email inexistant, afficher un message d'erreur
        $_SESSION['login_error'] = "Email incorrect.";
        header("Location: connexion.php"); // Redirigez vers la page de connexion
        exit();
    }

    $stmt_check_email->close();
    $conn->close();
} else {
    // Rediriger vers la page de connexion si les données POST sont absentes ou vides
    header("Location: connexion.php");
    exit();
}
?>
