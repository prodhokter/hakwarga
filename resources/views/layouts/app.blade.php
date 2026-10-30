<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 dark:bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' - HakWarga' : 'HakWarga - Transparansi Penyaluran Bansos & Pemenuhan Hak Publik' }}</title>
    <meta name="description" content="Platform transparansi pemenuhan hak bantuan sosial warga: Resi Tracker, Peta Anomali, Kanal Lapor Pungli, dan Scorecard SLA Instansi.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="flex min-h-full flex-col text-slate-900 dark:text-slate-100 bg-slate-50 dark:bg-slate-950 antialiased font-sans transition-colors duration-200"
      x-data="{
          mobileOpen: false,
          bannerVisible: sessionStorage.getItem('dismiss_sim_banner') !== 'true',
          darkMode: document.documentElement.classList.contains('dark'),
          toggleDark() {
              this.darkMode = !this.darkMode;
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
                  localStorage.setItem('theme', 'dark');
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.setItem('theme', 'light');
              }
          },
          dismissBanner() {
              this.bannerVisible = false;
              sessionStorage.setItem('dismiss_sim_banner', 'true');
          }
      }">

    {{-- Accessibility Skip Link --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-md focus:bg-teal-700 focus:px-4 focus:py-2 focus:text-white focus:outline-none focus:ring-2 focus:ring-teal-900 shadow-md">
        Lompat ke konten utama
    </a>

    {{-- Session Dismissable Simulation Banner with Ethics Preservation --}}
    @if(config('hakwarga.simulated_banner', true))
    <div x-show="bannerVisible" x-cloak class="bg-amber-100 dark:bg-amber-950/80 border-b border-amber-300 dark:border-amber-800 text-amber-950 dark:text-amber-200 px-4 py-2 text-xs sm:text-sm font-medium transition-all" role="alert">
        <div class="max-w-6xl mx-auto flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 flex-1">
                <span class="inline-flex items-center rounded-sm bg-amber-800 dark:bg-amber-700 text-amber-50 px-1.5 py-0.5 text-[10px] font-bold tracking-wider uppercase shrink-0">
                    Data Simulasi
                </span>
                <span class="text-xs sm:text-xs leading-tight">
                    Situs dalam tahap evaluasi kompetisi MIA 2026. Seluruh data penerima, penyaluran, dan resi adalah <strong>DATA SIMULASI</strong>.
                </span>
            </div>
            <button type="button" @click="dismissBanner()" class="text-amber-800 dark:text-amber-400 hover:text-amber-950 dark:hover:text-amber-100 p-1 rounded-md shrink-0 focus:outline-none focus:ring-2 focus:ring-amber-700" aria-label="Tutup pemberitahuan simulasi">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    {{-- Header / Sticky Navigation --}}
    <header class="sticky top-0 z-40 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Brand Identity --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-700 rounded-md p-1">
                        <div class="w-8 h-8 rounded-lg bg-teal-700 flex items-center justify-center text-white font-bold text-lg font-display shadow-xs">
                            H
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1.5">
                                <span class="text-lg font-extrabold tracking-tight text-slate-900 dark:text-white font-display">HakWarga</span>
                                <span x-show="!bannerVisible" x-cloak class="text-[9px] font-bold bg-amber-100 dark:bg-amber-900/60 text-amber-800 dark:text-amber-300 px-1.5 py-0.2 rounded border border-amber-300 dark:border-amber-700">
                                    Simulasi
                                </span>
                            </div>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium leading-none">Transparansi Hak Publik</span>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation Links --}}
                <nav class="hidden lg:flex items-center gap-1" aria-label="Navigasi Utama">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-xs font-semibold rounded-md {{ request()->routeIs('home') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }} focus-visible:ring-2 focus-visible:ring-teal-700 transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('tracker.index') }}" class="px-3 py-2 text-xs font-semibold rounded-md {{ request()->routeIs('tracker.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }} focus-visible:ring-2 focus-visible:ring-teal-700 transition-colors">
                        Lacak Resi
                    </a>
                    <a href="{{ route('map.index') }}" class="px-3 py-2 text-xs font-semibold rounded-md {{ request()->routeIs('map.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }} focus-visible:ring-2 focus-visible:ring-teal-700 transition-colors">
                        Peta Anomali
                    </a>
                    <a href="{{ route('report.choose') }}" class="px-3 py-2 text-xs font-semibold rounded-md {{ request()->routeIs('report.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }} focus-visible:ring-2 focus-visible:ring-teal-700 transition-colors">
                        Lapor Pungli &amp; Sanggah
                    </a>
                    <a href="{{ route('scorecard.index') }}" class="px-3 py-2 text-xs font-semibold rounded-md {{ request()->routeIs('scorecard.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }} focus-visible:ring-2 focus-visible:ring-teal-700 transition-colors">
                        Scorecard SLA
                    </a>
                    <a href="{{ route('data.index') }}" class="px-3 py-2 text-xs font-semibold rounded-md {{ request()->routeIs('data.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }} focus-visible:ring-2 focus-visible:ring-teal-700 transition-colors">
                        Data Publik
                    </a>
                </nav>

                {{-- Action Controls & Dark Mode Toggle --}}
                <div class="hidden lg:flex items-center gap-3">
                    {{-- Theme Toggle --}}
                    <button type="button" @click="toggleDark()" class="p-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-700" :aria-label="darkMode ? 'Beralih ke mode terang' : 'Beralih ke mode gelap'">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" x-cloak class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    {{-- Differentiated CTA: Lapor Pungli Anonim --}}
                    <a href="{{ route('report.choose') }}" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 px-3.5 py-2 text-xs font-bold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-teal-700 min-h-[40px] transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Lapor Pungli Anonim
                    </a>
                </div>

                {{-- Mobile Hamburger & Dark Toggle Button --}}
                <div class="flex items-center gap-1 lg:hidden">
                    <button type="button" @click="toggleDark()" class="p-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-700 min-h-[44px] min-w-[44px]" :aria-label="darkMode ? 'Beralih ke mode terang' : 'Beralih ke mode gelap'">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    <button type="button" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-700 min-h-[44px] min-w-[44px]" aria-label="Buka menu navigasi mobile">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Drawer Overlay --}}
        <div x-show="mobileOpen" x-cloak class="fixed inset-0 z-50 lg:hidden" @keydown.window.escape="mobileOpen = false">
            {{-- Backdrop blur --}}
            <div x-show="mobileOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="mobileOpen = false" aria-hidden="true"></div>

            {{-- Drawer Content --}}
            <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" class="relative z-50 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-6 pt-4 pb-8 shadow-xl max-h-[85vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <span class="text-sm font-bold text-slate-900 dark:text-white font-display">Menu Navigasi</span>
                    <button type="button" @click="mobileOpen = false" class="p-1 rounded-md text-slate-500 hover:text-slate-900 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        Beranda
                    </a>
                    <a href="{{ route('tracker.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('tracker.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        Lacak Resi Penyaluran
                    </a>
                    <a href="{{ route('map.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('map.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        Peta Anomali Bansos
                    </a>
                    <a href="{{ route('report.choose') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('report.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        Lapor Pungli &amp; Sanggah
                    </a>
                    <a href="{{ route('scorecard.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('scorecard.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        Scorecard SLA Instansi
                    </a>
                    <a href="{{ route('data.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('data.*') ? 'bg-teal-50 dark:bg-teal-950 text-teal-800 dark:text-teal-300' : 'text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                        Metodologi &amp; Data Publik
                    </a>
                    <a href="{{ route('ticket.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">
                        Cek Status Tiket Aduan
                    </a>
                    <a href="{{ route('about') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">
                        Tentang &amp; Privasi
                    </a>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('report.choose') }}" class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 px-4 py-3 text-sm font-bold text-white shadow-xs">
                        Lapor Pungli Anonim
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    {{-- Global Toast Component --}}
    <div id="hw-toast" class="fixed bottom-5 right-5 z-50 transform transition-all duration-300 translate-y-20 opacity-0 pointer-events-none bg-slate-900 text-white px-4 py-2.5 rounded-lg shadow-lg text-xs font-semibold flex items-center gap-2 border border-slate-700">
        <span id="hw-toast-icon" class="text-emerald-400 font-bold">&check;</span>
        <span id="hw-toast-msg">Notifikasi</span>
    </div>

    {{-- Footer --}}
    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 mt-20 py-12 transition-colors">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-md bg-teal-700 flex items-center justify-center text-white font-bold text-sm">
                            H
                        </div>
                        <span class="text-base font-bold text-slate-900 dark:text-white font-display">HakWarga</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Platform web transparansi bantuan sosial dan pemenuhan hak publik independen. Dirancang untuk memastikan hak warga sampai utuh tanpa potongan.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3 font-display">Prinsip Privasi &amp; Keamanan</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Sesuai amanat UU Perlindungan Data Pribadi (UU No. 27/2022), sistem ini tidak menyimpan atau menampilkan NIK mentah. Pelacakan dilakukan berbasis kode resi resmi tanpa membuka identitas warga ke publik.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3 font-display">Tautan Penting</h3>
                    <ul class="text-xs space-y-2 text-slate-600 dark:text-slate-400">
                        <li>
                            <a href="{{ route('tracker.index') }}" class="hover:text-teal-700 dark:hover:text-teal-400 underline focus-visible:ring-2 focus-visible:ring-teal-700">Lacak Nomor Resi</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:text-teal-700 dark:hover:text-teal-400 underline focus-visible:ring-2 focus-visible:ring-teal-700">Metodologi &amp; Perlindungan Warga</a>
                        </li>
                        <li>
                            <a href="/admin" class="hover:text-teal-700 dark:hover:text-teal-400 underline focus-visible:ring-2 focus-visible:ring-teal-700">Panel Petugas &amp; Admin (/admin)</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-200 dark:border-slate-800 mt-8 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 dark:text-slate-400 gap-2">
                <p>&copy; 2026 HakWarga. Seluruh data demonstrasi adalah data sintetis simulasi.</p>
                <p>Zona Waktu: Asia/Jakarta</p>
            </div>
        </div>
    </footer>

    <script>
        window.hwToast = (message, isError = false) => {
            const toast = document.getElementById('hw-toast');
            const msg = document.getElementById('hw-toast-msg');
            const icon = document.getElementById('hw-toast-icon');
            if (!toast || !msg) return;

            msg.textContent = message;
            if (isError) {
                icon.textContent = '✕';
                icon.className = 'text-rose-400 font-bold';
            } else {
                icon.textContent = '✓';
                icon.className = 'text-emerald-400 font-bold';
            }

            toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
            }, 3000);
        };
    </script>
    @stack('scripts')
</body>
</html>
