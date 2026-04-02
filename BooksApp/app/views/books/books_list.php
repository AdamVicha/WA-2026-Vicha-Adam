<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Knihovna - Seznam knih</title>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen flex flex-col">
    
    <header class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold">Aplikace Knihovna</h1> 
            <nav>
                <ul class="flex gap-4 m-0 p-0 list-none">
                    <li><a href="<?= BASE_URL ?>/index.php" class="hover:text-indigo-200 transition">Seznam knih</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?url=book/create" class="bg-white text-indigo-600 px-4 py-2 rounded-md font-semibold hover:bg-indigo-50 transition shadow-sm">Přidat novou knihu</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="flex-grow max-w-6xl mx-auto w-full px-4 py-8">
        
        <?php if (isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages'])): ?>
            <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-3 pointer-events-none">
                <?php foreach ($_SESSION['flash_messages'] as $index => $msg): ?>
                    <?php
                        // Barvy a ikony podle typu zprávy
                        $border = 'border-gray-200'; $iconColor = 'text-gray-500'; $icon = 'ℹ️';
                        if ($msg['type'] === 'success') { $border = 'border-green-500'; $iconColor = 'text-green-500'; $icon = '✅'; }
                        if ($msg['type'] === 'error') { $border = 'border-red-500'; $iconColor = 'text-red-500'; $icon = '❌'; }
                        if ($msg['type'] === 'notice') { $border = 'border-amber-500'; $iconColor = 'text-amber-500'; $icon = '⚠️'; }
                    ?>
                    <div class="toast-message pointer-events-auto flex items-center p-4 min-w-[300px] bg-white rounded-lg shadow-xl border-l-4 <?= $border ?> transform transition-all duration-300 translate-x-0 opacity-100" id="toast-<?= $index ?>">
                        <div class="flex-shrink-0 <?= $iconColor ?> text-xl mr-3">
                            <?= $icon ?>
                        </div>
                        <div class="flex-grow text-gray-700 font-medium text-sm">
                            <?= htmlspecialchars($msg['text']) ?>
                        </div>
                        <button onclick="closeToast('toast-<?= $index ?>')" class="ml-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php unset($_SESSION['flash_messages']); ?>

            <script>
                // Funkce pro manuální zavření s animací
                function closeToast(id) {
                    const toast = document.getElementById(id);
                    if (toast) {
                        toast.classList.remove('translate-x-0', 'opacity-100');
                        toast.classList.add('translate-x-full', 'opacity-0'); // Odjede doprava a zprůhlední se
                        setTimeout(() => toast.remove(), 300); // Smaže element z DOM po dokončení animace
                    }
                }

                // Automatické schování všech toustů po 4 sekundách
                document.addEventListener('DOMContentLoaded', () => {
                    const toasts = document.querySelectorAll('.toast-message');
                    toasts.forEach((toast, index) => {
                        setTimeout(() => {
                            closeToast(toast.id);
                        }, 4000 + (index * 500)); // Pokud je jich víc, mizí postupně s odstupem půl vteřiny
                    });
                });
            </script>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-700 m-0">Dostupné knihy</h2>
            </div>

            <?php if (empty($books)): ?>
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">V databázi se zatím nenachází žádné knihy.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-200">
                                <th class="p-4 font-semibold">ID</th>
                                <th class="p-4 font-semibold">Název knihy</th>
                                <th class="p-4 font-semibold">Autor</th>
                                <th class="p-4 font-semibold">Rok</th>
                                <th class="p-4 font-semibold">Cena</th>
                                <th class="p-4 font-semibold text-center">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($books as $book): ?>
                                <tr class="hover:bg-indigo-50 transition duration-150">
                                    <td class="p-4 text-gray-500">#<?= htmlspecialchars($book['id']) ?></td>
                                    <td class="p-4 font-medium text-gray-900"><?= htmlspecialchars($book['title']) ?></td>
                                    <td class="p-4 text-gray-600"><?= htmlspecialchars($book['author']) ?></td>
                                    <td class="p-4 text-gray-600"><?= htmlspecialchars($book['year']) ?></td>
                                    <td class="p-4 text-gray-600 font-semibold"><?= htmlspecialchars($book['price']) ?> Kč</td>
                                    <td class="p-4 text-center space-x-2">
                                        <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="text-indigo-600 hover:text-indigo-900 font-medium">Detail</a>
                                        <span class="text-gray-300">|</span>
                                        <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-amber-500 hover:text-amber-700 font-medium">Upravit</a>
                                        <span class="text-gray-300">|</span>
                                        <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="text-red-500 hover:text-red-700 font-medium">Smazat</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-gray-800 text-gray-400 py-6 mt-auto">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p>&copy; WA 2026 - Výukový projekt | Stylováno pomocí Tailwind CSS</p>
        </div>
    </footer>
</body>
</html>