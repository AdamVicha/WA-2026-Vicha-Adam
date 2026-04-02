<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Přidat novou knihu</title>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen flex flex-col">
    <header class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-3xl mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold">Aplikace Knihovna</h1> 
            <nav>
                <a href="<?= BASE_URL ?>/index.php" class="text-indigo-100 hover:text-white transition font-medium">&larr; Zpět na seznam</a>
            </nav>
        </div>
    </header>

    <main class="flex-grow max-w-3xl mx-auto w-full px-4 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">
            <div class="mb-6 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-semibold text-gray-800">Přidat novou knihu</h2>
                <p class="text-gray-500 text-sm mt-1">Vyplňte údaje a uložte knihu do databáze.</p>
            </div>
            
            <form action="<?= BASE_URL ?>/index.php?url=book/store" method="post" enctype="multipart/form-data" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Název knihy <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>
                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Autor <span class="text-red-500">*</span></label>
                        <input type="text" id="author" name="author" placeholder="Příjmení Jméno" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                        <input type="text" id="isbn" name="isbn" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Rok vydání <span class="text-red-500">*</span></label>
                        <input type="number" id="year" name="year" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategorie</label>
                        <input type="text" id="category" name="category" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>
                    <div>
                        <label for="subcategory" class="block text-sm font-medium text-gray-700 mb-1">Podkategorie</label>
                        <input type="text" id="subcategory" name="subcategory" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Cena knihy (Kč)</label>
                        <input type="number" id="price" name="price" step="0.5" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>
                    <div>
                        <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Odkaz</label>
                        <input type="text" id="link" name="link" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Popis knihy</label>
                    <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">Popis knihy: </textarea>
                </div>    

                <div class="border-2 border-dashed border-gray-300 rounded-md p-6 text-center hover:bg-indigo-50 transition cursor-pointer">
                    <label class="cursor-pointer block w-full h-full">
                        <span class="block text-indigo-600 font-semibold text-lg">Klikněte pro výběr souborů</span>
                        <span class="block text-sm text-gray-500 mt-1">JPG / PNG / WebP – více souborů najednou</span>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-md shadow-sm transition duration-150">
                        Uložit knihu do DB
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-gray-800 text-gray-400 py-6 mt-auto">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <p>&copy; WA 2026 - Výukový projekt | Stylováno pomocí Tailwind CSS</p>
        </div>
    </footer>
</body>
</html>