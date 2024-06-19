<?php
session_start();
require('database.php');

if (!isset($_SESSION['loginAdmin'])) {
    header("Location: authentifier.php");
    exit;
}

$idEmploye = $_POST['idEmploye'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$dateNaissance = $_POST['dateNaissance'];
$idDepartement = $_POST['idDepartement'];
$photoProfil = null;

if ($_FILES['photoProfil']['size'] > 0) {
    $photoProfil = file_get_contents($_FILES['photoProfil']['tmp_name']);
}

$updateQuery = "UPDATE employe SET nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance, idDepartement = :idDepartement";
$params = [
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':dateNaissance' => $dateNaissance,
    ':idDepartement' => $idDepartement,
    ':idEmploye' => $idEmploye
];

if ($photoProfil !== null) {
    $updateQuery .= ", photoProfil = :photoProfil";
    $params[':photoProfil'] = $photoProfil;
}

$updateQuery .= " WHERE idEmploye = :idEmploye";

$statement = $pdo->prepare($updateQuery);
$statement->execute($params);

$_SESSION['success_save'] = "Les informations de l'employé ont été mises à jour avec succès.";
header("Location: espaceprive.php");
exit;
?>
