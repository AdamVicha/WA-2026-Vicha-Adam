<?php require_once '../app/views/layout/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-white">Nahrát klip</h2>
        <p class="text-slate-400 mt-1">Sdílej svůj nejlepší herní moment s ostatními.</p>
    </div>

    <form action="<?= BASE_URL ?>/index.php?url=clip/store" method="post" enctype="multipart/form-data" class="bg-slate-800 p-6 md:p-8 rounded-xl border border-slate-700 shadow-lg space-y-6">
        
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Název klipu <span class="text-brand">*</span></label>
            <input type="text" name="title" required placeholder="Např. Clutch 1v5 s AWP" 
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Hra <span class="text-brand">*</span></label>
            <input type="text" name="game" required placeholder="Např. CS2, Valorant, GTA V..." 
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Popis (volitelné)</label>
            <textarea name="description" rows="4" placeholder="Co se v klipu stalo?" 
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition resize-y"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Video soubor (MP4, WebM) <span class="text-brand">*</span></label>
            
            <div class="relative flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-600 border-dashed rounded-lg cursor-pointer bg-slate-700/30 hover:bg-slate-700/50 hover:border-brand transition">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p class="mb-2 text-sm text-slate-400"><span class="font-semibold text-white">Klikněte pro výběr</span> nebo přetáhněte soubor</p>
                        <p class="text-xs text-slate-500">MAX. velikost závisí na serveru (obvykle 40MB)</p>
                    </div>
                    <input type="file" name="video" accept="video/mp4, video/webm" required class="hidden" id="video-upload" />
                </label>
            </div>
            <p id="file-name-display" class="text-sm text-brand mt-2 font-medium hidden">Vybráno: <span></span></p>
        </div>

        <div class="pt-2 border-t border-slate-700/50">
            <button type="submit" class="w-full bg-brand text-slate-900 font-bold py-3 px-4 rounded-lg hover:bg-cyan-400 transition shadow-[0_0_15px_rgba(0,210,255,0.2)] hover:shadow-[0_0_20px_rgba(0,210,255,0.4)] mt-4">
                Zveřejnit klip
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('video-upload').addEventListener('change', function(e) {
        const display = document.getElementById('file-name-display');
        if (e.target.files.length > 0) {
            display.querySelector('span').textContent = e.target.files[0].name;
            display.classList.remove('hidden');
        } else {
            display.classList.add('hidden');
        }
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>