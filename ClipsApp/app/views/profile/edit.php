<?php require_once '../app/views/layout/header.php'; ?>
<?php /** @var array $user */ ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-white">Upravit profil</h2>
            <p class="text-slate-400 mt-1">Nastavte si fotku a napište něco o sobě.</p>
        </div>
        <a href="<?= BASE_URL ?>/index.php?url=profile/show/<?= $user['id'] ?>" class="text-slate-400 hover:text-white transition text-sm font-bold">&larr; Zpět na profil</a>
    </div>

    <form action="<?= BASE_URL ?>/index.php?url=profile/update" method="post" enctype="multipart/form-data" class="bg-slate-800 p-6 md:p-8 rounded-xl border border-slate-700 shadow-lg space-y-6">
        
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">O mně (Bio)</label>
            <textarea name="bio" rows="4" placeholder="Napište něco o sobě, svých oblíbených hrách..." 
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand resize-y"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Profilový obrázek (Avatar)</label>
            <div class="flex items-center gap-6">
                <?php if (!empty($user['avatar_path']) && $user['avatar_path'] !== 'default_avatar.png'): ?>
                    <img src="<?= BASE_URL ?>/uploads/avatars/<?= htmlspecialchars($user['avatar_path']) ?>" class="w-20 h-20 rounded-full border-2 border-slate-600 object-cover">
                <?php else: ?>
                    <div class="w-20 h-20 rounded-full border-2 border-slate-600 bg-slate-700 flex items-center justify-center font-bold text-white text-2xl">
                        <?= strtoupper(substr(htmlspecialchars($user['username']), 0, 1)) ?>
                    </div>
                <?php endif; ?>
                
                <div class="flex-grow">
                    <input type="file" name="avatar" accept="image/png, image/jpeg, image/jpg, image/webp" 
                        class="block w-full text-sm text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-600 cursor-pointer transition">
                    <p class="text-xs text-slate-500 mt-2">Doporučený formát: PNG, JPG. Bude oříznuto do kruhu.</p>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-700/50">
            <button type="submit" class="w-full bg-brand text-slate-900 font-bold py-3 px-4 rounded-lg hover:bg-cyan-400 transition shadow-[0_0_15px_rgba(0,210,255,0.2)]">
                Uložit změny v profilu
            </button>
        </div>
    </form>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>