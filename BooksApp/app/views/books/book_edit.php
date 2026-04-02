<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Upravit knihu</title>
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
                <h2 class="text-2xl font-semibold text-gray-800">Upravit knihu (ID: <?= htmlspecialchars($book['id'] ?? '') ?>)</h2>
                <p class="text-gray-500 text-sm mt-1">Upravujete data pro knihu: <strong class="text-indigo-600"><?= htmlspecialchars($book['title'] ?? '') ?></strong></p>
            </div>
            
            <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id'] ?? '') ?>" method="post" enctype="multipart/form-data" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label for="id_display" class="block text-sm font-medium text-gray-500 mb-1">ID v databázi (nelze měnit)</label>
                        <input type="text" id="id_display" value="<?= htmlspecialchars($book['id'] ?? '') ?>" readonly class="w-full border border-gray-200 bg-gray-50 text-gray-500 rounded-md p-2.5 cursor-not-allowed outline-none">
                    </div>
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Název knihy <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title'] ?? '') ?>" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                    </div>
                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Autor <span class="text-red-500">*</span></label>
                        <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author'] ?? '') ?>" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                    </div>
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Rok vydání <span class="text-red-500">*</span></label>
                        <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year'] ?? '') ?>" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategorie </label>
                        <input type="text" id="category" name="category" value="<?= htmlspecialchars($book['category'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                    </div>
                    <div>
                        <label for="subcategory" class="block text-sm font-medium text-gray-700 mb-1">Podkategorie </label>
                        <input type="text" id="subcategory" name="subcategory" value="<?= htmlspecialchars($book['subcategory'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Cena knihy (Kč)</label>
                        <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                    </div>
                    <div>
                        <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Odkaz</label>
                        <input type="text" id="link" name="link" value="<?= htmlspecialchars($book['link'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Popis knihy</label>
                    <textarea id="description" name="description" rows="5" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition"><?= htmlspecialchars($book['description'] ?? '') ?></textarea>
                </div>    

                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Obrázky (zatím neřešíme, můžete ignorovat)</label>
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 transition cursor-pointer">
                </div>

                <div class="pt-4 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="w-full md:w-auto bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 px-8 rounded-md shadow-sm transition duration-150">
                        Uložit změny
                    </button>
                    <a href="<?= BASE_URL ?>/index.php" class="w-full md:w-auto bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 px-8 rounded-md text-center transition duration-150">
                        Zrušit a zpět
                    </a>
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