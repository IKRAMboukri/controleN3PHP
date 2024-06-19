<?php
session_start();
require('database.php');

if (!isset($_SESSION['loginAdmin'])) {
    header("Location: authentifier.php");
    exit;
}

if (isset($_GET['idEmploye'])) {
    $idEmploye = $_GET['idEmploye'];

    $statement = $pdo->prepare("DELETE FROM employe WHERE idEmploye = :idEmploye");
    $statement->execute([':idEmploye' => $idEmploye]);

    $_SESSION['success_save'] = "L'employé a été supprimé avec succès.";
}

header("Location: espaceprive.php");
exit;
?>
