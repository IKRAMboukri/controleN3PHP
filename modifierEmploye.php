<?php
session_start();
require('database.php');

if (!isset($_SESSION['loginAdmin'])) {
    header("Location: authentifier.php");
    exit;
}

$idEmploye = $_GET['idEmploye'];

$statement = $pdo->prepare("SELECT * FROM employe WHERE idEmploye = :idEmploye");
$statement->execute([':idEmploye' => $idEmploye]);
$employe = $statement->fetch(PDO::FETCH_ASSOC);

if (!$employe) {
    echo "Erreur: employé introuvable.";
    exit;
}

$statement_depts = $pdo->prepare("SELECT * FROM departement");
$statement_depts->execute();
$departements = $statement_depts->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Modifier Employé</title>
</head>
<body>
    <header class="bg-gray-200 container mx-auto flex items-center justify-between h-24">
        <h1 class="font-bold text-4xl m-5 text-red-500">Modifier Employé</h1>
        <form action="deconnecter.php" method="post">
            <button class="border border-white rounded-full font-bold px-8 py-2" type="submit">Se Déconnecter</button>
        </form>
    </header>
    <div class="flex justify-center items-center h-screen">
        <div class="w-11/12 p-12 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12 px-6 py-10 sm:px-10 sm:py-6 bg-white rounded-lg shadow-md lg:shadow-lg">
            <form action="updateEmploye.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idEmploye" value="<?= $employe['idEmploye'] ?>" />
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="nom">Nom</label>
                    <input type="text" name="nom" class="block w-full py-3 px-3 mt-2 text-gray-800 appearance-none border-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" value="<?= $employe['nom'] ?>" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="prenom">Prénom</label>
                    <input type="text" name="prenom" class="block w-full py-3 px-3 mt-2 text-gray-800 appearance-none border-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" value="<?= $employe['prenom'] ?>" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="dateNaissance">Date de Naissance</label>
                    <input type="date" name="dateNaissance" class="block w-full py-3 px-3 mt-2 text-gray-800 appearance-none border-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" value="<?= $employe['dateNaissance'] ?>" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="idDepartement">Département</label>
                    <select name="idDepartement" class="block w-full py-3 px-3 mt-2 text-gray-800 appearance-none border-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" required>
                        <?php foreach ($departements as $departement): ?>
                            <option value="<?= $departement['idDepartement'] ?>" <?= $employe['idDepartement'] == $departement['idDepartement'] ? 'selected' : '' ?>><?= $departement['intitule'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="photoProfil">Photo de Profil</label>
                    <input type="file" name="photoProfil" class="block w-full py-3 px-3 mt-2 text-gray-800 appearance-none border-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" />
                    <?php if ($employe['photoProfil']): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($employe['photoProfil']) ?>" alt="Photo" style="width: 50px; height: 50px;" />
                    <?php endif; ?>
                </div>
                <button type="submit" class="w-full py-3 mt-10 bg-[#063970] rounded-md font-medium text-white uppercase focus:outline-none hover:shadow-none">Enregistrer</button>
            </form>
        </div>
    </div>
</body>
</html>
