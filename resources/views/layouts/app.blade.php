<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' - HakWarga' : 'HakWarga - Transparansi Penyaluran Bansos & Pemenuhan Hak Publik' }}</title>
    <meta name="description" content="Platform transparansi pemenuhan hak bantuan sosial warga: Resi Tracker, Peta Anomali, Kanal Lapor Pungli, dan Scorecard SLA Instansi.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="flex min-h-full flex-col text-slate-900 bg-slate-50 antialiased font-sans">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-md focus:bg-teal-700 focus:px-4 focus:py-2 focus:text-white focus:outline-none focus:ring-2 focus:ring-teal-900">
        Lompat ke konten utama
    </a>

    {{-- Persistent Simulation Banner --}}
    @if(config('hakwarga.simulated_banner', true))
    <div class="bg-amber-100 border-b border-amber-300 text-amber-950 px-4 py-2.5 text-center text-xs sm:text-sm font-medium" role="alert">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-2">
            <span class="inline-flex items-center rounded-sm bg-amber-800 text-amber-50 px-1.5 py-0.5 text-[11px] font-bold tracking-wide uppercase">
                Data Simulasi
            </span>
            <span>
                Situs ini dalam tahap pengujian &amp; evaluasi kompetisi MIA 2026. Seluruh data penerima, penyaluran, dan resi adalah data simulasi.
            </span>
        </div>
    </div>
    @endif

    {{-- Header / Navigation --}}
    <header class="sticky top-0 z-40 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Brand --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-700 rounded-md p-1">
                        <div class="w-8 h-8 rounded-md bg-teal-700 flex items-center justify-center text-white font-bold text-lg font-display">
                            H
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold tracking-tight text-slate-900 font-display">HakWarga</span>
                            <span class="text-[11px] text-slate-500 font-medium leading-none">Transparansi Hak Publik</span>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-1" aria-label="Navigasi Utama">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('home') ? 'bg-teal-50 text-teal-800' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }} focus-visible:ring-2 focus-visible:ring-teal-700">
                        Beranda
                    </a>
                    <a href="{{ route('tracker.index') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('tracker.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }} focus-visible:ring-2 focus-visible:ring-teal-700">
                        Lacak Resi
                    </a>
                    <a href="{{ route('map.index') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('map.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }} focus-visible:ring-2 focus-visible:ring-teal-700">
                        Peta Anomali
                    </a>
                    <a href="{{ route('report.choose') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('report.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }} focus-visible:ring-2 focus-visible:ring-teal-700">
                        Lapor Pungli &amp; Sanggah
                    </a>
                    <a href="{{ route('scorecard.index') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('scorecard.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }} focus-visible:ring-2 focus-visible:ring-teal-700">
                        Scorecard SLA
                    </a>
                    <a href="{{ route('data.index') }}" class="px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('data.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }} focus-visible:ring-2 focus-visible:ring-teal-700">
                        Data Publik
                    </a>
                </nav>

                {{-- Action CTA --}}
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('tracker.index') }}" class="inline-flex items-center justify-center rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-xs hover:bg-teal-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-700 min-h-[44px]">
                        Cek Resi Bansos
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="flex md:hidden" x-data="{ mobileOpen: false }">
                    <button type="button" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" class="inline-flex items-center justify-center p-2 rounded-md text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-700 min-h-[44px] min-w-[44px]" aria-label="Buka menu navigasi">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    {{-- Mobile Navigation Overlay --}}
                    <div x-show="mobileOpen" x-cloak @click.away="mobileOpen = false" class="absolute top-16 left-0 right-0 bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-1 shadow-lg">
                        <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-teal-50 text-teal-800' : 'text-slate-800 hover:bg-slate-50' }}">
                            Beranda
                        </a>
                        <a href="{{ route('tracker.index') }}" class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('tracker.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-800 hover:bg-slate-50' }}">
                            Lacak Resi Penyaluran
                        </a>
                        <a href="{{ route('map.index') }}" class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('map.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-800 hover:bg-slate-50' }}">
                            Peta Anomali Bansos
                        </a>
                        <a href="{{ route('report.choose') }}" class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('report.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-800 hover:bg-slate-50' }}">
                            Lapor Pungli &amp; Sanggah
                        </a>
                        <a href="{{ route('scorecard.index') }}" class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('scorecard.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-800 hover:bg-slate-50' }}">
                            Scorecard SLA Instansi
                        </a>
                        <a href="{{ route('data.index') }}" class="block px-3 py-2.5 rounded-md text-base font-medium {{ request()->routeIs('data.*') ? 'bg-teal-50 text-teal-800' : 'text-slate-800 hover:bg-slate-50' }}">
                            Metodologi &amp; Data Publik
                        </a>
                        <a href="{{ route('ticket.index') }}" class="block px-3 py-2.5 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">
                            Cek Status Tiket Aduan
                        </a>
                        <a href="{{ route('about') }}" class="block px-3 py-2.5 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">
                            Tentang &amp; Privasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200 mt-16 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded bg-teal-700 flex items-center justify-center text-white font-bold text-sm">
                            H
                        </div>
                        <span class="text-base font-bold text-slate-900 font-display">HakWarga</span>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Platform web transparansi bantuan sosial dan pemenuhan hak publik independen. Dibuat untuk memastikan hak warga sampai utuh tanpa potongan.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 mb-3 font-display">Prinsip Privasi &amp; Keamanan</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Sesuai amanat UU Perlindungan Data Pribadi (UU No. 27/2022), sistem ini tidak menyimpan atau menampilkan NIK mentah. Pelacakan dilakukan berbasis kode resi resmi tanpa membuka identitas warga ke publik.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 mb-3 font-display">Tautan Terkait</h3>
                    <ul class="text-sm space-y-2 text-slate-600">
                        <li>
                            <a href="{{ route('tracker.index') }}" class="hover:text-teal-700 underline focus-visible:ring-2 focus-visible:ring-teal-700">Lacak Nomor Resi</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:text-teal-700 underline focus-visible:ring-2 focus-visible:ring-teal-700">Metodologi &amp; Perlindungan Warga</a>
                        </li>
                        <li>
                            <a href="/admin" class="hover:text-teal-700 underline focus-visible:ring-2 focus-visible:ring-teal-700">Panel Petugas &amp; Admin (/admin)</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-200 mt-8 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
                <p>&copy; 2026 HakWarga. Seluruh data demonstrasi adalah data sintetis simulasi.</p>
                <p>Zona Waktu: Asia/Jakarta</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
