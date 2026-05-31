<?php require_once '../app/views/layout/header.php'; ?>  

<div class="mb-8 flex justify-between items-end">
    <h2 class="text-3xl font-bold text-white tracking-tight">Nejnovější klipy</h2>
</div>

<?php if (empty($clips)): ?>
    <div class="bg-slate-800 rounded-xl p-10 text-center border border-slate-700">
        <p class="text-lg text-slate-400">Zatím tu nejsou žádná videa. Buď první a nahraj nějaký epický moment!</p>
    </div>
<?php else: ?>
    <div class="space-y-8">
        <?php foreach ($clips as $clip): ?>
            <article class="bg-slate-800 rounded-xl overflow-hidden border border-slate-700 shadow-lg">
                
                <div class="p-4 flex justify-between items-center border-b border-slate-700/50">
                    <div class="flex items-center gap-3">
                        <?php if (!empty($clip['avatar_path']) && $clip['avatar_path'] !== 'default_avatar.png'): ?>
                            <img src="<?= BASE_URL ?>/uploads/avatars/<?= htmlspecialchars($clip['avatar_path']) ?>" class="w-10 h-10 rounded-full object-cover border border-slate-600">
                        <?php else: ?>
                            <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center font-bold text-white">
                                <?= strtoupper(substr(htmlspecialchars($clip['author_name']), 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <p class="font-bold text-white text-sm"><?= htmlspecialchars($clip['author_name']) ?></p>
                            <p class="text-xs text-brand font-medium"><?= htmlspecialchars($clip['game']) ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="w-full bg-black">
                    <video class="w-full max-h-[600px]" controls preload="metadata">
                        <source src="<?= BASE_URL ?>/uploads/videos/<?= htmlspecialchars($clip['video_path']) ?>" type="video/mp4">
                        Váš prohlížeč nepodporuje video tag.
                    </video>
                </div>
                
                <div class="p-4">
                    <h3 class="text-xl font-bold text-white mb-2"><?= htmlspecialchars($clip['title']) ?></h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4"><?= nl2br(htmlspecialchars($clip['description'])) ?></p>
                    
                    <div class="flex gap-6 border-t border-slate-700/50 pt-4 items-center">
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <a href="<?= BASE_URL ?>/index.php?url=clip/toggleUpvote/<?= $clip['id'] ?>" 
                               class="flex items-center gap-2 text-sm font-medium transition <?= $clip['user_upvoted'] ? 'text-brand' : 'text-slate-400 hover:text-brand' ?>">
                                <svg class="w-6 h-6" fill="<?= $clip['user_upvoted'] ? 'currentColor' : 'none' ?>" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                <?= $clip['upvote_count'] ?> Upvotes
                            </a>
                        <?php else: ?>
                            <span class="flex items-center gap-2 text-sm font-medium text-slate-500 cursor-not-allowed" title="Pro lajkování se musíte přihlásit">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                <?= $clip['upvote_count'] ?> Upvotes
                            </span>
                        <?php endif; ?>

                        <a href="<?= BASE_URL ?>/index.php?url=clip/show/<?= $clip['id'] ?>" class="text-slate-400 hover:text-white transition flex items-center gap-2 text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Komentáře
                        </a>

                        <?php 
                        $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                        $isAuthor = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $clip['user_id'];
                        
                        if ($isAdmin || $isAuthor): 
                        ?>
                            <a href="<?= BASE_URL ?>/index.php?url=clip/edit/<?= $clip['id'] ?>" 
                               class="ml-auto text-amber-500 hover:text-amber-400 font-bold text-sm bg-amber-500/10 px-3 py-1.5 rounded transition flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Upravit
                            </a>
                            <a href="<?= BASE_URL ?>/index.php?url=admin/deleteClip/<?= $clip['id'] ?>" 
                               onclick="return confirm('Opravdu smazat toto video?')"
                               class="text-red-500 hover:text-red-400 font-bold text-sm bg-red-500/10 px-3 py-1.5 rounded transition flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Smazat
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once '../app/views/layout/footer.php'; ?>