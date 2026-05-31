<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClipShare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#00d2ff',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-900 text-slate-300 font-sans min-h-screen flex flex-col">

    <header class="bg-slate-800 border-b border-slate-700 sticky top-0 z-50 shadow-md">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            
            <a href="<?= BASE_URL ?>/index.php" class="transition-transform hover:scale-105 duration-300">
                <svg class="h-10 w-auto drop-shadow-[0_0_10px_rgba(0,210,255,0.4)]" viewBox="0 0 230 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    
                    <path d="M5 15C5 9.47715 9.47715 5 15 5H35C40.5228 5 45 9.47715 45 15V35C45 40.5228 40.5228 45 35 45H15C9.47715 45 5 40.5228 5 35V15Z" fill="#0f172a" stroke="#00d2ff" stroke-width="2.5"/>
                    
                    <path d="M19 16.5C19 14.9602 20.6667 14.0013 22 14.7735L32.5 20.836C33.8333 21.606 33.8333 23.5303 32.5 24.3002L22 30.3628C20.6667 31.135 19 30.176 19 28.6363V16.5Z" fill="#00d2ff"/>
                    
                    <circle cx="45" cy="10" r="3" fill="#ffffff"/>
                    <circle cx="5" cy="40" r="3" fill="#ffffff"/>

                    <text x="58" y="34" font-family="system-ui, -apple-system, sans-serif" font-size="28" font-weight="900" fill="#ffffff" letter-spacing="-1">Clip<tspan fill="#00d2ff">Share</tspan></text>
                    
                    <text x="61" y="46" font-family="system-ui, -apple-system, sans-serif" font-size="9" font-weight="bold" fill="#64748b" letter-spacing="3">GAMING MOMENTS</text>
                </svg>
            </a>
            
            <nav class="flex items-center gap-6">
                <a href="<?= BASE_URL ?>/index.php" class="text-sm font-medium text-slate-300 hover:text-white transition">Feed</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="<?= BASE_URL ?>/index.php?url=admin/dashboard" class="text-amber-400 text-sm font-bold hover:text-amber-300 transition">👑 Admin Panel</a>
                    <?php endif; ?>
                    
                    <a href="<?= BASE_URL ?>/index.php?url=clip/create" class="bg-brand text-slate-900 text-sm font-bold px-4 py-2 rounded-lg hover:bg-cyan-400 transition shadow-[0_0_15px_rgba(0,210,255,0.3)]">Nahrát klip</a>
                    
                    <div class="relative group py-4">
                        <button class="flex items-center gap-2 text-sm font-medium text-slate-300 hover:text-white transition focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <?= htmlspecialchars($_SESSION['user_name']) ?>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div class="absolute right-0 top-full mt-[-10px] w-48 bg-slate-800 border border-slate-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden">
                            <a href="<?= BASE_URL ?>/index.php?url=profile/show/<?= $_SESSION['user_id'] ?>" class="block px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700 hover:text-white transition">Zobrazit profil</a>
                            <a href="<?= BASE_URL ?>/index.php?url=profile/edit" class="block px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700 hover:text-white transition">Upravit profil</a>
                            <div class="border-t border-slate-700"></div>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/logout" class="block px-4 py-2.5 text-sm text-red-400 hover:bg-slate-700 hover:text-red-300 transition">Odhlásit</a>
                        </div>
                    </div>
                
                <?php else: ?>
                    
                    <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-slate-300 hover:text-white text-sm font-medium transition">Přihlásit</a>
                    <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="border border-brand text-brand text-sm font-bold px-4 py-2 rounded-lg hover:bg-brand hover:text-slate-900 transition">Registrace</a>
                
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="flex-grow max-w-4xl mx-auto w-full px-4 py-8">