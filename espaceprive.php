<?php
session_start();
require('database.php');

if (!isset($_SESSION['loginAdmin'])) {
    header("Location: authentifier.php");
    exit;
}

$statement = $pdo->prepare("SELECT nom, prenom FROM admin WHERE loginAdmin = :loginAdmin");
$statement->execute([
    ':loginAdmin' => $_SESSION['loginAdmin']
]);
$admin = $statement->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "Erreur: impossible de récupérer les informations de l'administrateur.";
    exit;
}

$heure_actuelle = date("H");
$message = ($heure_actuelle < 18) ? "Bonjour" : "Bonsoir";

$statement_employes = $pdo->prepare("SELECT e.idEmploye, e.nom, e.prenom, e.dateNaissance, d.intitule, e.photoProfil FROM employe e JOIN departement d ON e.idDepartement = d.idDepartement");
$statement_employes->execute();
$employes = $statement_employes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <header class="bg-gray-200 container mx-auto flex items-center justify-between h-24">
        <h1 class="font-bold text-4xl m-5 text-red-500">Espace privé</h1>
        <form action="deconnecter.php" method="post">
            <button class="border border-white rounded-full font-bold px-8 py-2" type="submit">Se Déconnecter</button>
        </form>
    </header>
    <?php if (isset($_SESSION["success_save"])): ?>
        <div class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-md text-green-700 bg-green-200 border border-green-300 ">
            <div slot="avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mx-2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="text-xl font-normal max-w-full flex-initial"><?= $_SESSION["success_save"] ?></div>
            <div class="flex flex-auto flex-row-reverse">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>
            </div>
        </div>
    <?php
        unset($_SESSION['success_save']);
    endif;
    ?>
    <div class="heading text-center font-bold text-3xl m-5 text-blue-500"><?php echo $message . ", " . ($admin['prenom']) . " " . ($admin['nom']); ?></div>
    <div class="heading text-center text-xl m-5 text-black-700">Liste des employés</div>
    <a href="insererEmploye.php" class="btn bg-green-200">Ajouter</a>
    <table class="min-w-full border-collapse block md:table">
        <thead class="block md:table-header-group">
            <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto md:relative">
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Nom</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Prénom</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Date de naissance</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Département</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Photo</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Actions</th>
            </tr>
        </thead>
        <tbody class="block md:table-row-group">
            <?php foreach ($employes as $employe): ?>
                <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><?= $employe['nom'] ?></td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><?= $employe['prenom'] ?></td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><?= $employe['dateNaissance'] ?></td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><?= $employe['intitule'] ?></td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><img src="data:image/jpeg;base64,<?= base64_encode($employe['photoProfil']) ?>" alt="Photo" style="width: 50px; height: 50px;" /></td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <a href="modifierEmploye.php?idEmploye=<?= $employe['idEmploye'] ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded inline-block">Modifier</a>
                        <a href="supprimerEmploye.php?idEmploye=<?= $employe['idEmploye'] ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded inline-block">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
