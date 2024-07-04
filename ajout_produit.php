<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style de la page d'ajout de produit */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #000;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #555;
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
            text-align: center;
            margin-top: 10px;
        }
        .back-link a {
            color: #007bff;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un Produit</h2>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message success"><?php echo $_SESSION['success_message']; ?></div>
            <?php unset($_SESSION['success_message']); ?>
        <?php elseif (isset($_SESSION['error_message'])): ?>
            <div class="message error"><?php echo $_SESSION['error_message']; ?></div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form action="process_ajout_produit.php" method="POST">
            <div class="form-group">
                <label for="nom_produit">Nom du Produit</label>
                <input type="text" id="nom_produit" name="nom_produit" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" step="0.01" id="prix" name="prix" required>
            </div>
            <div class="form-group">
                <label for="quantite">Quantité</label>
                <input type="number" id="quantite" name="quantite" required>
            </div>
            <button type="submit">Ajouter le Produit</button>
        </form>

        <div class="back-link">
            <p><a href="dashboard_admin.php">Retour au Dashboard</a></p>
        </div>
    </div>
</body>
</html>
