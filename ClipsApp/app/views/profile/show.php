<?php require_once '../app/views/layout/header.php'; ?>
<?php /** @var array $user */ ?>
<?php /** @var array $userClips */ ?>

<div class="max-w-4xl mx-auto">
    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-lg p-8 mb-8 flex flex-col md:flex-row gap-8 items-center md:items-start relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-slate-900 to-slate-800 opacity-50 z-0 border-b border-slate-700"></div>

        <div class="z-10 relative">
            <?php if (!empty($user['avatar_path']) && $user['avatar_path'] !== 'default_avatar.png'): ?>
                <img src="<?= BASE_URL ?>/uploads/avatars/<?= htmlspecialchars($user['avatar_path']) ?>" alt="Avatar" class="w-32 h-32 rounded-full border-4 border-brand object-cover shadow-[0_0_20px_rgba(0,210,255,0.3)]">
            <?php else: ?>
                <div class="w-32 h-32 rounded-full border-4 border-slate-600 bg-slate-700 flex items-center justify-center text-5xl font-bold text-white shadow-lg">
                    <?= strtoupper(substr(htmlspecialchars($user['username']), 0, 1)) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="z-10 flex-grow text-center md:text-left mt-6 md:mt-14">
            <h2 class="text-3xl font-bold text-white flex items-center justify-center md:justify-start gap-3">
                <?= htmlspecialchars($user['username']) ?>
                <?php if ($user['role'] === 'admin'): ?>
                    <span class="bg-amber-500/20 text-amber-400 px-2 py-1 rounded text-xs font-bold border border-amber-500/30 uppercase">Admin</span>
                <?php endif; ?>
            </h2>
            <p class="text-slate-400 text-sm mt-1">Členem od: <?= date('d.m.Y', strtotime($user['created_at'])) ?></p>
            
            <div class="mt-4 bg-slate-900/50 p-4 rounded-lg border border-slate-700">
                <p class="text-slate-300 italic">
                    <?= !empty($user['bio']) ? nl2br(htmlspecialchars($user['bio'])) : 'Tento uživatel o sobě zatím nic nenapsal...' ?>
                </p>
            </div>
        </div>

        <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['id']): ?>
            <div class="z-10 md:absolute md:top-6 md:right-6">
                <a href="<?= BASE_URL ?>/index.php?url=profile/edit" class="bg-brand text-slate-900 text-sm font-bold px-4 py-2 rounded-lg hover:bg-cyan-400 transition shadow-[0_0_15px_rgba(0,210,255,0.3)] flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Upravit profil
                </a>
            </div>
        <?php endif; ?>
    </div>

    <h3 class="text-2xl font-bold text-white mb-6">Klipy uživatele (<?= count($userClips) ?>)</h3>
    
    <?php if (empty($userClips)): ?>
        <div class="bg-slate-800 rounded-xl p-8 text-center border border-slate-700">
            <p class="text-slate-400">Tento uživatel zatím nenahrál žádné klipy.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach($userClips as $clip): ?>
                <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden shadow hover:border-brand transition">
                    <video class="w-full aspect-video object-cover bg-black" muted onmouseover="this.play()" onmouseout="this.pause()">
                        <source src="<?= BASE_URL ?>/uploads/videos/<?= htmlspecialchars($clip['video_path']) ?>" type="video/mp4">
                    </video>
                    <div class="p-4">
                        <h4 class="font-bold text-white truncate"><?= htmlspecialchars($clip['title']) ?></h4>
                        <p class="text-brand text-xs font-medium mt-1"><?= htmlspecialchars($clip['game']) ?></p>
                        <a href="<?= BASE_URL ?>/index.php?url=clip/show/<?= $clip['id'] ?>" class="block text-center w-full bg-slate-700 hover:bg-slate-600 text-white text-sm font-bold py-2 mt-4 rounded transition">Zobrazit klip</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>