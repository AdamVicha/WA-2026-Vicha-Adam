<?php require_once '../app/views/layout/header.php'; ?>
<div class="max-w-md mx-auto mt-10">
    <div class="bg-slate-800 p-8 rounded-xl border border-slate-700 shadow-xl">
        <h2 class="text-3xl font-bold text-white mb-6 text-center">Přihlášení</h2>
        
        <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">E-mail</label>
                <input type="email" name="email" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Heslo</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
            </div>
            <button type="submit" class="w-full bg-brand text-slate-900 font-bold py-3 px-4 rounded-lg hover:bg-cyan-400 transition shadow-[0_0_15px_rgba(0,210,255,0.2)] mt-2">
                Přihlásit se
            </button>
        </form>
        <p class="text-center text-slate-400 text-sm mt-6">
            Nemáte účet? <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-brand hover:underline">Zaregistrujte se</a>.
        </p>
    </div>
</div>
<?php require_once '../app/views/layout/footer.php'; ?>