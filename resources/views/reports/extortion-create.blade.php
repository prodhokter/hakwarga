@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    <div class="space-y-2">
        <a href="{{ route('report.choose') }}" class="inline-flex items-center gap-1.5 text-xs text-teal-800 dark:text-teal-400 hover:underline font-semibold">
            &larr; Kembali ke pilihan jenis laporan
        </a>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-xs font-bold">
                <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                100% Anonim
            </span>
            <span class="text-xs text-slate-500 dark:text-slate-400">Tanpa Nama, NIK, atau IP Pelapor</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-display">
            Form Laporan Pungutan Liar &amp; Pemotongan Bansos
        </h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
            Laporkan setiap pemotongan uang tunai, iuran liar, atau penahanan kartu bansos. Identitas Anda tidak pernah ditanyakan atau dicatat.
        </p>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-900 dark:text-rose-200 rounded-xl p-4 text-xs space-y-1">
            <p class="font-bold">Mohon periksa kembali formulir Anda:</p>
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Multi-Step Wizard Form Container --}}
    <div class="hw-card p-6 sm:p-8 rounded-2xl shadow-xs"
         x-data="{
             currentStep: 1,
             regionId: '{{ old('region_id', '') }}',
             regionName: '',
             category: '{{ old('category', '') }}',
             categoryName: '',
             amount: '{{ old('amount_claimed', '') }}',
             description: '{{ old('description', isset($prefillResi) && $prefillResi ? 'Laporan terkait nomor resi penyaluran ' . $prefillResi . ': ' : '') }}',
             init() {
                 const saved = sessionStorage.getItem('hw_draft_extortion');
                 if (saved && !this.description) {
                     this.description = saved;
                 }
             },
             updateDraft() {
                 sessionStorage.setItem('hw_draft_extortion', this.description);
             },
             goToStep2() {
                 if (!this.regionId) {
                     window.hwToast('Silakan pilih wilayah kejadian.', true);
                     return;
                 }
                 if (!this.category) {
                     window.hwToast('Silakan pilih bentuk pemotongan atau pungli.', true);
                     return;
                 }
                 const regEl = document.getElementById('region-select');
                 this.regionName = regEl.options[regEl.selectedIndex]?.text || '';
                 const catEl = document.getElementById('category-select');
                 this.categoryName = catEl.options[catEl.selectedIndex]?.text || '';
                 this.currentStep = 2;
             },
             goToStep3() {
                 if (!this.description || this.description.trim().length < 20) {
                     window.hwToast('Uraian kejadian minimal 20 karakter.', true);
                     return;
                 }
                 this.currentStep = 3;
             }
         }">

        {{-- Wizard Progress Stepper Bar --}}
        <div class="mb-8 border-b border-slate-100 dark:border-slate-800 pb-5">
            <div class="flex items-center justify-between text-xs font-semibold">
                <div class="flex items-center gap-2" :class="currentStep >= 1 ? 'text-teal-700 dark:text-teal-400 font-bold' : 'text-slate-400'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs"
                          :class="currentStep >= 1 ? 'bg-teal-700 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600'">1</span>
                    <span>Wilayah &amp; Kategori</span>
                </div>
                <div class="h-0.5 flex-1 mx-3 bg-slate-200 dark:bg-slate-800" :class="currentStep >= 2 ? 'bg-teal-600' : ''"></div>
                <div class="flex items-center gap-2" :class="currentStep >= 2 ? 'text-teal-700 dark:text-teal-400 font-bold' : 'text-slate-400'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs"
                          :class="currentStep >= 2 ? 'bg-teal-700 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600'">2</span>
                    <span>Kronologi</span>
                </div>
                <div class="h-0.5 flex-1 mx-3 bg-slate-200 dark:bg-slate-800" :class="currentStep >= 3 ? 'bg-teal-600' : ''"></div>
                <div class="flex items-center gap-2" :class="currentStep === 3 ? 'text-teal-700 dark:text-teal-400 font-bold' : 'text-slate-400'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs"
                          :class="currentStep === 3 ? 'bg-teal-700 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-600'">3</span>
                    <span>Kirim</span>
                </div>
            </div>
        </div>

        <form action="{{ route('report.extortion.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Honeypot anti-bot --}}
            <div class="hidden" aria-hidden="true">
                <label for="honeypot-field">Jangan isi bidang ini</label>
                <input type="text" id="honeypot-field" name="honeypot" tabindex="-1" autocomplete="off">
            </div>

            {{-- STEP 1: Wilayah & Kategori Pungli --}}
            <div x-show="currentStep === 1" class="space-y-5">
                <div>
                    <label for="region-select" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-1.5">
                        Wilayah Terjadinya Pungutan <span class="text-rose-600">*</span>
                    </label>
                    <select id="region-select" name="region_id" x-model="regionId" required class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3.5 py-2.5 text-sm text-slate-900 dark:text-white focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[44px]">
                        <option value="">Pilih Kelurahan, Kecamatan, atau Kabupaten</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">
                                {{ $region->name }} ({{ $region->level->label() }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Pilih lokasi desa atau titik salur di mana pemotongan terjadi.</p>
                </div>

                <div>
                    <label for="category-select" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-1.5">
                        Bentuk Pemotongan atau Pungli <span class="text-rose-600">*</span>
                    </label>
                    <select id="category-select" name="category" x-model="category" required class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3.5 py-2.5 text-sm text-slate-900 dark:text-white focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[44px]">
                        <option value="">Pilih Bentuk Kejanggalan</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->value }}">
                                {{ $category->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="button" @click="goToStep2()" class="inline-flex items-center gap-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 px-6 py-2.5 text-sm font-semibold text-white shadow-xs min-h-[44px] transition-colors">
                        Lanjut ke Kronologi &rarr;
                    </button>
                </div>
            </div>

            {{-- STEP 2: Nominal & Kronologi --}}
            <div x-show="currentStep === 2" x-cloak class="space-y-5">
                <div>
                    <label for="amount-input" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-1.5">
                        Nominal Potongan atau Biaya (Rupiah, Opsional)
                    </label>
                    <input
                        type="number"
                        id="amount-input"
                        name="amount_claimed"
                        x-model="amount"
                        placeholder="Contoh: 50000"
                        min="0"
                        step="1000"
                        class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3.5 py-2.5 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 font-mono min-h-[44px]"
                    >
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Kosongkan jika bukan berupa potongan uang tunai.</p>
                </div>

                <div>
                    <label for="description-input" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-1.5">
                        Uraian Kejadian Secara Kronologis <span class="text-rose-600">*</span>
                    </label>
                    <textarea
                        id="description-input"
                        name="description"
                        x-model="description"
                        @input="updateDraft()"
                        rows="6"
                        required
                        placeholder="Ceritakan waktu kejadian, lokasi titik salur, modus yang dilakukan, atau alasan yang disampaikan oleh oknum..."
                        class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3.5 py-2.5 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-teal-700 focus:ring-2 focus:ring-teal-700"
                    ></textarea>
                    <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400 mt-1.5">
                        <span>Minimal 20 karakter &bull; Terketik: <strong x-text="description.length"></strong></span>
                        <span class="text-emerald-700 dark:text-emerald-400 font-semibold">&check; NIK 16 digit &amp; No. HP disensor otomatis</span>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="button" @click="currentStep = 1" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white min-h-[44px]">
                        &larr; Kembali
                    </button>
                    <button type="button" @click="goToStep3()" class="inline-flex items-center gap-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 px-6 py-2.5 text-sm font-semibold text-white shadow-xs min-h-[44px] transition-colors">
                        Tinjau &amp; Konfirmasi &rarr;
                    </button>
                </div>
            </div>

            {{-- STEP 3: Tinjau & Konfirmasi Pengiriman --}}
            <div x-show="currentStep === 3" x-cloak class="space-y-5">
                <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-5 border border-slate-200 dark:border-slate-700 space-y-3">
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                        Ringkasan Laporan Anonim Anda
                    </h3>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between border-b border-slate-200 dark:border-slate-700 pb-1.5">
                            <span class="text-slate-500">Wilayah:</span>
                            <span class="font-bold text-slate-900 dark:text-white" x-text="regionName"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 dark:border-slate-700 pb-1.5">
                            <span class="text-slate-500">Bentuk Pungli:</span>
                            <span class="font-bold text-slate-900 dark:text-white" x-text="categoryName"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 dark:border-slate-700 pb-1.5" x-show="amount">
                            <span class="text-slate-500">Nominal:</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white" x-text="'Rp' + Number(amount || 0).toLocaleString('id-ID')"></span>
                        </div>
                        <div class="pt-1">
                            <span class="text-slate-500 block mb-1">Uraian Kejadian:</span>
                            <p class="text-slate-800 dark:text-slate-200 italic whitespace-pre-line bg-white dark:bg-slate-900 p-3 rounded-lg border border-slate-200 dark:border-slate-800" x-text="description"></p>
                        </div>
                    </div>
                </div>

                {{-- Reassurance of Anonymity --}}
                <div class="rounded-lg bg-emerald-50 dark:bg-emerald-950/60 p-4 border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-900 dark:text-emerald-200 space-y-1">
                    <p class="font-bold">Konfirmasi Privasi Mutlak:</p>
                    <p>Setelah menekan tombol di bawah, sistem membuat nomor tiket resmi dan kode rahasia satu kali tampil. Tidak ada catatan nama atau IP Anda.</p>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="button" @click="currentStep = 2" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white min-h-[44px]">
                        &larr; Ubah Kronologi
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 px-6 py-3 text-sm font-bold text-white shadow-sm min-h-[44px] transition-colors"
                    >
                        Kirim Laporan &amp; Ambil Kode Tiket &rarr;
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
