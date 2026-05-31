<?php require_once '../app/views/layout/header.php'; ?>
<?php /** @var array $clip */ ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-white">Upravit klip</h2>
        <a href="<?= BASE_URL ?>/index.php?url=clip/show/<?= $clip['id'] ?>" class="text-brand hover:underline text-sm font-bold">&larr; Zpět na detail klipu</a>
    </div>

    <form action="<?= BASE_URL ?>/index.php?url=clip/update" method="post" class="bg-slate-800 p-6 md:p-8 rounded-xl border border-slate-700 shadow-lg space-y-6">
        <input type="hidden" name="id" value="<?= $clip['id'] ?>">
        
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Název klipu <span class="text-brand">*</span></label>
            <input type="text" name="title" required value="<?= htmlspecialchars($clip['title']) ?>" 
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Hra <span class="text-brand">*</span></label>
            <input type="text" name="game" required value="<?= htmlspecialchars($clip['game']) ?>" 
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Popis</label>
            <textarea name="description" rows="4" 
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition resize-y"><?= htmlspecialchars($clip['description']) ?></textarea>
        </div>

        <div class="pt-2 border-t border-slate-700/50">
            <button type="submit" class="w-full bg-brand text-slate-900 font-bold py-3 px-4 rounded-lg hover:bg-cyan-400 transition shadow-[0_0_15px_rgba(0,210,255,0.2)]">
                Uložit změny
            </button>
        </div>
    </form>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>