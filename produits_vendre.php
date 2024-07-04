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

// Récupérer tous les produits de la base de données
$sql = "SELECT * FROM produits";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style de la page des produits */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #000;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #4CAF50;
            color: #fff;
        }
        .error {
            background-color: #f44336;
            color: #fff;
        }
        .back-link {
            margin-top: 10px;
            text-align: center;
        }
        .back-link a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Liste des Produits</h2>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="message success"><?php echo $_SESSION['success_message']; ?></div>
        <?php unset($_SESSION['success_message']); ?>
    <?php elseif (isset($_SESSION['error_message'])): ?>
        <div class="message error"><?php echo $_SESSION['error_message']; ?></div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <table>
        <tr>
            <th>Nom du Produit</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Quantité</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["nom_produit"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["prix"]; ?></td>
                    <td><?php echo $row["stock"]; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Aucun produit trouvé</td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="back-link">
        <p><a href="ajout_produit.php">Ajouter un autre produit</a> | <a href="dashboard_vendeur.php">Retour au Dashboard</a></p>
    </div>
</body>
</html>

<?php
$conn->close();
?>
