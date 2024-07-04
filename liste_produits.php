<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: connexion.php");
    exit();
}

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

// Récupérer la liste des produits
$sql = "SELECT * FROM produits";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Produits</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assurez-vous d'avoir un fichier styles.css pour la mise en page -->
</head>
<body>
    <h2>Liste des Produits</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom du Produit</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>ID du Fournisseur</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_produit'] . "</td>";
                echo "<td>" . $row['nom_produit'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['prix'] . "</td>";
                echo "<td>" . $row['stock'] . "</td>";
                echo "<td>" . $row['fournisseur_id'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Aucun produit trouvé</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
