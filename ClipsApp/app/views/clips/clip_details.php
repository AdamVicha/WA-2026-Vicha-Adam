<?php require_once '../app/views/layout/header.php'; ?>  
<?php /** @var array $clip */ ?>
<?php /** @var array $comments */ ?>  

<div class="mb-4">
    <a href="<?= BASE_URL ?>" class="text-brand hover:underline flex items-center gap-2 text-sm font-bold">
        &larr; Zpět na Feed
    </a>
</div>

<article class="bg-slate-800 rounded-xl overflow-hidden border border-slate-700 shadow-lg mb-8">
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
        <video class="w-full max-h-[700px]" controls autoplay>
            <source src="<?= BASE_URL ?>/uploads/videos/<?= htmlspecialchars($clip['video_path']) ?>" type="video/mp4">
        </video>
    </div>
    <div class="p-4">
        <h3 class="text-2xl font-bold text-white mb-2"><?= htmlspecialchars($clip['title']) ?></h3>
        <p class="text-slate-400 text-sm leading-relaxed"><?= nl2br(htmlspecialchars($clip['description'])) ?></p>
    </div>
</article>

<div class="bg-slate-800 rounded-xl border border-slate-700 shadow-lg p-6">
    <h3 class="text-xl font-bold text-white mb-6">Diskuze k videu</h3>

    <?php if(isset($_SESSION['user_id'])): ?>
        <form action="<?= BASE_URL ?>/index.php?url=comment/store" method="post" class="mb-8">
            <input type="hidden" name="clip_id" value="<?= $clip['id'] ?>">
            <textarea name="content" rows="3" required placeholder="Co si o tom myslíš?" 
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand mb-3 resize-y"></textarea>
            <button type="submit" class="bg-brand text-slate-900 font-bold py-2 px-6 rounded-lg hover:bg-cyan-400 transition shadow-[0_0_15px_rgba(0,210,255,0.2)]">Odeslat komentář</button>
        </form>
    <?php else: ?>
        <div class="bg-slate-700/30 border border-slate-600 rounded-lg p-4 text-center mb-8">
            <p class="text-slate-400">Pro přidání komentáře se musíte <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-brand hover:underline">přihlásit</a>.</p>
        </div>
    <?php endif; ?>

    <div class="space-y-4">
        <?php if(empty($comments)): ?>
            <p class="text-slate-500 text-center italic py-4">Zatím žádné komentáře. Buď první!</p>
        <?php else: ?>
            <?php foreach($comments as $comment): ?>
                <div class="bg-slate-700/20 p-4 rounded-lg border border-slate-700/50">
                    <div id="comment-display-<?= $comment['id'] ?>">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <?php if (!empty($comment['avatar_path']) && $comment['avatar_path'] !== 'default_avatar.png'): ?>
                                    <img src="<?= BASE_URL ?>/uploads/avatars/<?= htmlspecialchars($comment['avatar_path']) ?>" class="w-6 h-6 rounded-full object-cover border border-slate-600">
                                <?php else: ?>
                                    <div class="w-6 h-6 bg-slate-600 rounded-full flex items-center justify-center font-bold text-xs text-white">
                                        <?= strtoupper(substr(htmlspecialchars($comment['username']), 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <span class="font-bold text-white text-sm"><?= htmlspecialchars($comment['username']) ?></span>
                                <span class="text-xs text-slate-500"><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></span>
                            </div>
                            
                            <?php 
                            $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
                            if(isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $comment['user_id'] || $isAdmin)): 
                            ?>
                                <div class="flex gap-3">
                                    <a href="<?= BASE_URL ?>/index.php?url=comment/edit/<?= $comment['id'] ?>" class="text-amber-400 hover:text-amber-300 text-xs font-bold">Upravit</a>
                                    <a href="<?= BASE_URL ?>/index.php?url=comment/delete/<?= $comment['id'] ?>" onclick="return confirm('Smazat komentář?')" class="text-red-400 hover:text-red-300 text-xs font-bold">Smazat</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                    </div>

                    <?php if(isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $comment['user_id'] || $isAdmin)): ?>
                        <div id="comment-edit-form-<?= $comment['id'] ?>" class="hidden mt-2">
                            <form action="<?= BASE_URL ?>/index.php?url=comment/update" method="post">
                                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                <input type="hidden" name="clip_id" value="<?= $comment['clip_id'] ?>">
                                
                                <textarea name="content" rows="3" required class="w-full bg-slate-900 border border-brand/50 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand text-sm resize-y mb-2"><?= htmlspecialchars($comment['content']) ?></textarea>
                                
                                <div class="flex gap-2 justify-end">
                                    <button type="button" onclick="toggleCommentEdit(<?= $comment['id'] ?>)" class="text-slate-400 hover:text-white text-xs font-bold px-3 py-1.5 transition">
                                        Zrušit
                                    </button>
                                    <button type="submit" class="bg-brand text-slate-900 text-xs font-bold py-1.5 px-4 rounded hover:bg-cyan-400 transition">
                                        Uložit
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleCommentEdit(commentId) {
        const displayDiv = document.getElementById('comment-display-' + commentId);
        const editFormDiv = document.getElementById('comment-edit-form-' + commentId);
        
        if (displayDiv.classList.contains('hidden')) {
            displayDiv.classList.remove('hidden');
            editFormDiv.classList.add('hidden');
        } else {
            displayDiv.classList.add('hidden');
            editFormDiv.classList.remove('hidden');
        }
    }
</script>

<?php require_once '../app/views/layout/footer.php'; ?>