<?php
session_start();
require 'database.php';

if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['dateNaissance']) || empty($_POST['idDepartement'])) {
    echo '<script>alert("Veuillez remplir tous les champs.")</script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $statement = $pdo->prepare("INSERT INTO employe (nom, prenom, dateNaissance, idDepartement, photoProfil) 
    VALUES (:nom, :prenom, :dateNaissance, :idDepartement, :photoProfil)");

    // Handle photo upload
    $photoProfil = NULL;
    if (!empty($_FILES['photoProfil']['tmp_name'])) {
        $photoProfil = file_get_contents($_FILES['photoProfil']['tmp_name']);
    }

    $statement->execute([
        ':nom' => $_POST['nom'],
        ':prenom' => $_POST['prenom'],
        ':dateNaissance' => $_POST['dateNaissance'],
        ':idDepartement' => $_POST['idDepartement'],
        ':photoProfil' => $photoProfil
    ]);

    $_SESSION["success_save"] = "Employé ajouté avec succès";
    header('Location: espaceprive.php');
}
?>
