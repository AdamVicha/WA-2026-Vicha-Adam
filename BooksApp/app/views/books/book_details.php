<?php require_once '../app/views/layout/header.php'; ?>
    <main class="flex-grow max-w-4xl mx-auto w-full px-4 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start border-b border-gray-200 pb-6 mb-6 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($book['title'] ?? '') ?></h2>
                    <p class="text-xl text-gray-600 mt-2 font-medium">Autor: <?= htmlspecialchars($book['author'] ?? '') ?></p>
                </div>
                <div class="flex gap-3">
                    <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-md font-medium transition shadow-sm whitespace-nowrap">Upravit</a>
                    <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-medium transition shadow-sm whitespace-nowrap">Smazat</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-5">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kategorie / Podkategorie</h3>
                        <p class="text-lg font-medium text-gray-800">
                            <?= htmlspecialchars(!empty($book['category']) ? $book['category'] : 'Nepřiřazeno') ?>
                            <?php if (!empty($book['subcategory'])): ?>
                                <span class="text-gray-400 font-normal">/</span> <?= htmlspecialchars($book['subcategory']) ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rok vydání</h3>
                        <p class="text-lg text-gray-800"><?= htmlspecialchars($book['year'] ?? 'Neuvedeno') ?></p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Cena</h3>
                        <p class="text-xl font-bold text-indigo-600"><?= htmlspecialchars($book['price'] ?? '0') ?> Kč</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">ISBN</h3>
                        <p class="text-lg text-gray-800"><?= htmlspecialchars(!empty($book['isbn']) ? $book['isbn'] : 'Neuvedeno') ?></p>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Popis knihy</h3>
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200 min-h-[150px]">
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed"><?= htmlspecialchars(!empty($book['description']) ? $book['description'] : 'Tato kniha zatím nemá žádný popis.') ?></p>
                    </div>

                    <?php if (!empty($book['link'])): ?>
                        <div class="mt-5">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Externí odkaz</h3>
                            <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank" class="text-indigo-600 hover:text-indigo-800 hover:underline break-all"><?= htmlspecialchars($book['link']) ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
<?php require_once '../app/views/layout/footer.php'; ?>