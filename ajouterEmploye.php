<?php
session_start();
require('database.php');

// Remplir la liste déroulante des départements
$statement = $pdo->prepare('SELECT idDepartement, intitule FROM departement');
$statement->execute();
$departements = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200">
    <div class="heading text-center font-bold text-3xl m-5 text-yellow-500">Ajouter un employé</div>
    <div class="heading text-center text-l m-5 text-black-400">Veuillez remplir tous les champs</div>

    <style>
        body {background:white !important;}
    </style>

    <form action="traitement_ajouter.php" method="POST" enctype="multipart/form-data">
        <div class="editor mx-auto w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl">
            <div>
                <label for="nom" class="mb-2 block text-base font-medium text-[#07074D]"> Nom </label>
                <input type="text" name="nom" id="nom" class="w-full bg-gray-100 p-2 mb-4 rounded-md border border-[#e0e0e0] text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
            </div>
            <div>
                <label for="prenom" class="mb-2 block text-base font-medium text-[#07074D]"> Prénom </label>
                <input type="text" name="prenom" id="prenom" class="w-full bg-gray-100 p-2 mb-4 rounded-md border border-[#e0e0e0] text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
            </div>
            <div>
                <label for="dateNaissance" class="mb-2 block text-base font-medium text-[#07074D]"> Date Naissance </label>
                <input type="date" name="dateNaissance" id="dateNaissance" class="w-full bg-gray-100 p-2 mb-4 rounded-md border border-[#e0e0e0] text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
            </div>
            <div>
                <label for="photoProfil" class="mb-2 block text-base font-medium text-[#07074D]"> Photo profil </label>
                <input type="file" name="photoProfil" id="photoProfil" class="w-full bg-gray-100 p-2 mb-4 rounded-md border border-[#e0e0e0] text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
            <div>
                <label for="departement" class="mb-2 block text-base font-medium text-[#07074D]"> Département </label>
                <select name="idDepartement" id="departement" class="w-full bg-gray-100 p-2 mb-4 rounded-md border border-[#e0e0e0] text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
                    <option value="" disabled selected>Selectionnez votre département</option>
                    <?php foreach ($departements as $departement): ?>
                        <option value="<?php echo $departement['idDepartement']; ?>">
                            <?php echo $departement['intitule']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="buttons flex">
                <input class="btn border border-yellow-500 p-1 px-4 font-semibold cursor-pointer text-gray-100 ml-2 bg-yellow-500 hover:bg-yellow-600" type="submit" value="Ajouter">
            </div>
        </div>
    </form>
</body>
</html>
