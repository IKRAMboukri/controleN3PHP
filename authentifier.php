<?php
session_start();
$loginError = '';
if (isset($_SESSION['loginError'])) {
    $loginError = $_SESSION['loginError'];
}
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
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <div class="flex flex-col h-screen bg-gradient-to-b from-[#063970] to-blue-200">
        <div class="grid place-items-center mx-2 my-20 sm:my-auto" x-data="{ showPass: true }">
            <div class="w-11/12 p-12 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12 px-6 py-10 sm:px-10 sm:py-6 bg-white rounded-lg shadow-md lg:shadow-lg">
                <div class="text-center mb-4">
                    <h6 class="font-semibold text-[#063970] text-xl">Login</h6>
                </div>
                <form class="space-y-5" action="verification.php" method="POST">
                    <div>
                        <input id="loginAdmin" type="text" name="loginAdmin" class="block w-full py-3 px-3 mt-2 text-gray-800 appearance-none border-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" placeholder="Login" />
                    </div>

                    <div class="relative w-full">
                        <input :type="showPass ? 'password' : 'text'" id="password" name="motPasse" class="block w-full py-3 px-3 mt-2 mb-4 text-gray-800 appearance-none border-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" placeholder="Mot de passe" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <p class="font-semibold" @click="showPass = !showPass" x-text="showPass ? 'Show' : 'Hide'">Show</p>
                        </div>
                        <span class="text-red-500"><?= $loginError ?> </span>
                    </div>

                    <button type="submit" class="w-full py-3 mt-10 bg-[#063970] rounded-md font-medium text-white uppercase focus:outline-none hover:shadow-none">S'authentifier</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
