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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nom_produit'], $_POST['description'], $_POST['prix'], $_POST['quantite'])) {
    $nom_produit = $_POST['nom_produit'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO produits (nom_produit, description, prix, stock) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $nom_produit, $description, $prix, $quantite);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Le produit a été ajouté avec succès.";
    } else {
        $_SESSION['error_message'] = "Erreur lors de l'ajout du produit : " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    // Rediriger vers produits_vendre.php
    header("Location: produits_vendre.php");
    exit();
}
?>
