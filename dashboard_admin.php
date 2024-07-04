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

// Récupérer la liste des utilisateurs depuis la base de données
$sql = "SELECT id_utilisateur, nom_utilisateur, email, role FROM utilisateurs";
$result = $conn->query($sql);

// Vérifier si des utilisateurs existent
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Gestion du changement de rôle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'], $_POST['new_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    // Mettre à jour le rôle de l'utilisateur dans la base de données
    $sql_update_role = "UPDATE utilisateurs SET role = ? WHERE id_utilisateur = ?";
    $stmt = $conn->prepare($sql_update_role);
    $stmt->bind_param("si", $new_role, $user_id);

    if ($stmt->execute()) {
        // Succès de la mise à jour du rôle
        $_SESSION['success_message'] = "Le rôle de l'utilisateur a été mis à jour avec succès.";
        header("Location: dashboard_admin.php");
        exit();
    } else {
        // Erreur lors de la mise à jour
        $_SESSION['error_message'] = "Erreur lors de la mise à jour du rôle : " . $conn->error;
        header("Location: dashboard_admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclure votre fichier CSS ici -->
    <style>
        /* Vous pouvez ajouter du style spécifique si nécessaire, mais utilisez surtout le CSS externe */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .user-table th, .user-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .user-table th {
            background-color: #f2f2f2;
        }
        .role-select {
            padding: 5px;
            font-size: 14px;
        }
        .action-button {
            padding: 8px 16px;
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .action-button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .logout-link {
            display: block;
            width: 100px;
            text-align: center;
            padding: 8px 0;
            background-color: grey;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .logout-link:hover {
            background-color: grey;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Administrateur</h1>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message success"><?php echo $_SESSION['success_message']; ?></div>
            <?php unset($_SESSION['success_message']); ?>
        <?php elseif (isset($_SESSION['error_message'])): ?>
            <div class="message error"><?php echo $_SESSION['error_message']; ?></div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        
        <table class="user-table">
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Rôle actuel</th>
                <th>Changer de rôle</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id_utilisateur']; ?></td>
                    <td><?php echo $user['nom_utilisateur']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo ucfirst($user['role']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['id_utilisateur']; ?>">
                            <select name="new_role" class="role-select">
                                <option value="acheteur" <?php echo ($user['role'] == 'acheteur') ? 'selected' : ''; ?>>Acheteur</option>
                                <option value="vendeur" <?php echo ($user['role'] == 'vendeur') ? 'selected' : ''; ?>>Vendeur</option>
                                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            </select>
                            <button type="submit" class="action-button">Mettre à jour</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        
        <a href="deconnexion.php" class="logout-link">Déconnexion</a>
    </div>
</body>
</html>
