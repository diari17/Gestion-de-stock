<?php
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

// ID de l'utilisateur à définir en tant qu'administrateur
$user_id = 1;

// Préparer la requête SQL pour mettre à jour le rôle de l'utilisateur en administrateur
$sql = "UPDATE utilisateurs SET role = 'admin' WHERE id_utilisateur = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

// Exécuter la requête
if ($stmt->execute()) {
    echo "L'utilisateur avec l'ID $user_id est maintenant administrateur.";
} else {
    echo "Erreur lors de l'assignation du rôle d'administrateur : " . $conn->error;
}

// Fermer le statement
$stmt->close();

// Fermer la connexion à la base de données
$conn->close();
?>
