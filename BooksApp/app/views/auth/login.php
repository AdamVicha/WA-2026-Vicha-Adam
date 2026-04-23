<?php require_once '../app/views/layout/header.php'; ?>
<main class="flex-grow flex items-center justify-center px-4 py-12">
    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8 w-full max-w-md">
        <div class="mb-6 border-b border-gray-200 pb-4 text-center">
            <h2 class="text-2xl font-semibold text-gray-800">Přihlášení</h2>
            <p class="text-gray-500 text-sm mt-1">Vítejte zpět v naší Knihovně.</p>
        </div>
        
        <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post" class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                <input type="email" id="email" name="email" required autofocus class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Heslo</label>
                <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-md shadow-sm transition duration-150">
                    Přihlásit se
                </button>
            </div>
            
            <p class="text-center text-gray-500 text-sm mt-4">
                Nemáte ještě účet? <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-indigo-600 hover:text-indigo-800 font-medium">Zaregistrujte se</a>.
            </p>
        </form>
    </div>
</main>
<?php require_once '../app/views/layout/footer.php'; ?>