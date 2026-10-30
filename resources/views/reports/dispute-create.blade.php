@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    <div class="space-y-2">
        <a href="{{ route('report.choose') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-700 dark:text-slate-300 hover:underline font-semibold">
            &larr; Kembali ke pilihan laporan
        </a>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-900 text-white dark:bg-slate-100 dark:text-slate-900 text-xs font-bold font-mono">
                Sanggah Kelayakan
            </span>
            <span class="text-xs text-slate-500 dark:text-slate-400">Verifikasi Berkeadilan</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-display">
            Form Sanggah Kelayakan Penerima Bantuan Sosial
        </h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
            Sanggahan Anda membantu memastikan kuota bantuan sosial disalurkan tepat sasaran kepada keluarga yang benar-benar membutuhkan.
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

    <div class="starline-card p-6 sm:p-8 rounded-2xl shadow-xs"
         x-data="{
             desc: '{{ old('description', '') }}',
             init() {
                 const draft = sessionStorage.getItem('hw_draft_dispute');
                 if (draft && !this.desc) this.desc = draft;
             },
             saveDraft() {
                 sessionStorage.setItem('hw_draft_dispute', this.desc);
             }
         }">
        <form action="{{ route('report.dispute.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Honeypot anti-bot --}}
            <div class="hidden" aria-hidden="true">
                <label for="honeypot-dispute">Jangan isi bidang ini</label>
                <input type="text" id="honeypot-dispute" name="honeypot" tabindex="-1" autocomplete="off">
            </div>

            {{-- Wilayah --}}
            <div>
                <label for="region-select-dispute" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-1.5">
                    Wilayah Kelurahan / Desa Penerima <span class="text-rose-600">*</span>
                </label>
                <select id="region-select-dispute" name="region_id" required class="input-starline w-full">
                    <option value="">Pilih Kelurahan/Desa</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                            {{ $region->name }} ({{ $region->level->label() }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Program Bansos --}}
            <div>
                <label for="program-select" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-1.5">
                    Program Bantuan Sosial <span class="text-rose-600">*</span>
                </label>
                <select id="program-select" name="program_id" required class="input-starline w-full">
                    <option value="">Pilih Program Bansos</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }} ({{ $program->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Alasan Sanggah --}}
            <div>
                <label for="category-select-dispute" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-1.5">
                    Alasan Sanggah Kelayakan <span class="text-rose-600">*</span>
                </label>
                <select id="category-select-dispute" name="category" required class="input-starline w-full">
                    <option value="">Pilih Alasan Sanggahan</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->value }}" {{ old('category') == $category->value ? 'selected' : '' }}>
                            {{ $category->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Pihak yang Disanggah --}}
            <div>
                <label for="target-name-input" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-1.5">
                    Nama Warga / Kepala Keluarga yang Disanggah <span class="text-rose-600">*</span>
                </label>
                <input
                    type="text"
                    id="target-name-input"
                    name="target_beneficiary_name"
                    value="{{ old('target_beneficiary_name') }}"
                    placeholder="Contoh: Budi Santoso (RT 02/RW 03)"
                    required
                    class="input-starline w-full"
                >
            </div>

            {{-- Uraian Sanggahan --}}
            <div>
                <label for="dispute-description-input" class="block text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-1.5">
                    Uraian Fakta Lapangan <span class="text-rose-600">*</span>
                </label>
                <textarea
                    id="dispute-description-input"
                    name="description"
                    x-model="desc"
                    @input="saveDraft()"
                    rows="5"
                    required
                    placeholder="Jelaskan kondisi ekonomi riil, kepemilikan aset, atau bukti pendukung mengapa warga tersebut tidak memenuhi kriteria bansos..."
                    class="input-starline w-full"
                ></textarea>
                <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400 mt-1.5">
                    <span>Minimal 20 karakter &bull; Terketik: <strong x-text="desc.length"></strong></span>
                    <span class="text-emerald-700 dark:text-emerald-400 font-semibold">&check; NIK 16 digit &amp; No. HP disensor otomatis</span>
                </div>
            </div>

            {{-- Submit CTA --}}
            <div class="pt-3">
                <button
                    type="submit"
                    class="btn-starline-primary w-full text-center text-xs font-bold"
                >
                    Kirim Sanggahan &amp; Dapatkan Kode Tiket &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
