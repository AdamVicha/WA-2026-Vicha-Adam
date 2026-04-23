<?php require_once '../app/views/layout/header.php'; ?>  
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
                                        
                                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $book['created_by']): ?>
                                            <span class="text-gray-300">|</span>
                                            <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-amber-500 hover:text-amber-700 font-medium">Upravit</a>
                                            <span class="text-gray-300">|</span>
                                            <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="text-red-500 hover:text-red-700 font-medium">Smazat</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>
<?php require_once '../app/views/layout/footer.php'; ?>