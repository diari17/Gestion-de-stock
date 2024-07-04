<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestion_stock";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $telephone = $_POST['telephone'];
    $role = 'acheteur';  // Par défaut, l'utilisateur s'inscrit en tant qu'acheteur

    // Préparer et exécuter la requête SQL pour insérer l'utilisateur dans la table utilisateurs
    $sql = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, role) 
            VALUES ('$nom', '$prenom', '$email', '$mot_de_passe', '$role')";

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
