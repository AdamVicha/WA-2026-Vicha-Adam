<?php require_once '../app/views/layout/header.php'; ?>
<main class="flex-grow flex items-center justify-center px-4 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8 w-full max-w-2xl">
        <div class="mb-6 border-b border-gray-200 pb-4 text-center">
            <h2 class="text-2xl font-semibold text-gray-800">Nová registrace</h2>
            <p class="text-gray-500 text-sm mt-1">Vytvořte si účet pro správu vašeho knižního katalogu.</p>
        </div>
        
        <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2 mt-2">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Přihlašovací údaje</h3>
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Uživatelské jméno <span class="text-red-500">*</span></label>
                    <input type="text" id="username" name="username" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Heslo <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>

                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">Potvrzení hesla <span class="text-red-500">*</span></label>
                    <input type="password" id="password_confirm" name="password_confirm" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>

                <div class="md:col-span-2 mt-4">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Osobní údaje (Volitelné)</h3>
                </div>

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Křestní jméno</label>
                    <input type="text" id="first_name" name="first_name" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Příjmení</label>
                    <input type="text" id="last_name" name="last_name" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>

                <div class="md:col-span-2">
                    <label for="nickname" class="block text-sm font-medium text-gray-700 mb-1">Zobrazovaná přezdívka</label>
                    <input type="text" id="nickname" name="nickname" placeholder="Jak vám máme v aplikaci říkat?" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 mt-6">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-md shadow-sm transition duration-150">
                    Vytvořit účet
                </button>
                <p class="text-center text-gray-500 text-sm mt-4">
                    Už máte účet? <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-indigo-600 hover:text-indigo-800 font-medium">Přihlaste se zde</a>.
                </p>
            </div>
        </form>
    </div>
</main>
<?php require_once '../app/views/layout/footer.php'; ?>