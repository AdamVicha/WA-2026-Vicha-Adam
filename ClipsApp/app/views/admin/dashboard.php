<?php require_once '../app/views/layout/header.php'; ?>
<?php /** @var array $users */ ?>
<div class="max-w-4xl mx-auto">
    <div class="mt-12 mb-6 border-b border-slate-700 pb-4">
        <h2 class="text-3xl font-bold text-white">Správa klipů</h2>
        <p class="text-brand mt-1">Seznam všech nahraných videí na platformě</p>
    </div>

    <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden shadow-lg mb-10">
        <table class="w-full text-left">
            <thead class="bg-slate-900 border-b border-slate-700 text-slate-300 uppercase text-xs font-bold">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Název</th>
                    <th class="p-4">Hra</th>
                    <th class="p-4">Autor</th>
                    <th class="p-4">Datum</th>
                    <th class="p-4 text-center">Akce</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700 text-slate-300 text-sm">
                <?php if (empty($clips)): ?>
                    <tr><td colspan="6" class="p-4 text-center italic text-slate-500">Zatím nebyly nahrány žádné klipy.</td></tr>
                <?php else: ?>
                    <?php foreach ($clips as $c): ?>
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="p-4">#<?= $c['id'] ?></td>
                            <td class="p-4 font-bold text-white"><?= htmlspecialchars($c['title']) ?></td>
                            <td class="p-4 text-brand font-medium"><?= htmlspecialchars($c['game']) ?></td>
                            <td class="p-4"><?= htmlspecialchars($c['author_name']) ?></td>
                            <td class="p-4"><?= date('d.m.Y H:i', strtotime($c['created_at'])) ?></td>
                            <td class="p-4 text-center flex justify-center gap-2">
                                <a href="<?= BASE_URL ?>/index.php?url=admin/deleteClip/<?= $c['id'] ?>" 
                                   onclick="return confirm('Opravdu chcete tento klip trvale smazat ze serveru?')"
                                   class="text-red-400 hover:text-red-300 font-bold bg-red-400/10 px-3 py-1.5 rounded transition">Smazat video</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../app/views/layout/footer.php'; ?>