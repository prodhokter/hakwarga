@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <div class="space-y-2">
        <a href="{{ route('report.choose') }}" class="inline-flex items-center text-xs text-teal-800 hover:underline font-medium">
            &larr; Kembali ke pilihan laporan
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Form Laporan Pungutan Liar &amp; Pemotongan Bansos
        </h1>
        <p class="text-sm text-slate-600 leading-relaxed">
            Laporan Anda bersifat 100% anonim. Tidak ada kolom identitas pelapor dan alamat IP tidak disimpan.
        </p>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-900 rounded-lg p-4 text-xs space-y-1">
            <p class="font-bold">Mohon periksa kembali formulir Anda:</p>
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <form action="{{ route('report.extortion.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Honeypot anti-bot --}}
            <div class="hidden" aria-hidden="true">
                <label for="honeypot-field">Jangan isi bidang ini</label>
                <input type="text" id="honeypot-field" name="honeypot" tabindex="-1" autocomplete="off">
            </div>

            {{-- Wilayah --}}
            <div>
                <label for="region-select" class="block text-sm font-semibold text-slate-900 mb-1">
                    Wilayah Terjadinya Pungutan <span class="text-rose-600">*</span>
                </label>
                <select id="region-select" name="region_id" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[44px]">
                    <option value="">Pilih Wilayah Terkait</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                            {{ $region->name }} ({{ $region->level->label() }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-1">Pilih kelurahan, kecamatan, atau kabupaten lokasi kejadian.</p>
            </div>

            {{-- Kategori Pungli --}}
            <div>
                <label for="category-select" class="block text-sm font-semibold text-slate-900 mb-1">
                    Bentuk Pemotongan atau Pungli <span class="text-rose-600">*</span>
                </label>
                <select id="category-select" name="category" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[44px]">
                    <option value="">Pilih Bentuk Kejanggalan</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->value }}" {{ old('category') == $category->value ? 'selected' : '' }}>
                            {{ $category->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nominal Potongan (Opsional) --}}
            <div>
                <label for="amount-input" class="block text-sm font-semibold text-slate-900 mb-1">
                    Nominal Pemotongan / Biaya yang Ditarik (Rupiah, Opsional)
                </label>
                <input
                    type="number"
                    id="amount-input"
                    name="amount_claimed"
                    value="{{ old('amount_claimed') }}"
                    placeholder="Contoh: 50000"
                    min="0"
                    step="1000"
                    class="w-full rounded-md border border-slate-300 px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 font-mono min-h-[44px]"
                >
                <p class="text-xs text-slate-500 mt-1">Isi jika ada uang tunai yang dipotong oleh oknum.</p>
            </div>

            {{-- Uraian Kejadian --}}
            <div>
                <label for="description-input" class="block text-sm font-semibold text-slate-900 mb-1">
                    Uraian Kejadian Secara Jelas <span class="text-rose-600">*</span>
                </label>
                <textarea
                    id="description-input"
                    name="description"
                    rows="5"
                    required
                    placeholder="Jelaskan secara kronologis waktu, lokasi, modus pemotongan, atau alasan yang disampaikan oleh oknum di lapangan..."
                    class="w-full rounded-md border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-teal-700 focus:ring-2 focus:ring-teal-700"
                >{{ old('description') }}</textarea>
                <div class="flex items-center justify-between text-xs text-slate-500 mt-1">
                    <span>Minimal 20 karakter.</span>
                    <span class="text-emerald-700 font-medium">Nomor NIK &amp; Telepon disensor otomatis</span>
                </div>
            </div>

            {{-- Submit CTA --}}
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center rounded-md bg-teal-700 px-6 py-3 text-base font-semibold text-white hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-900 min-h-[44px]"
                >
                    Kirim Laporan Anonim &amp; Dapatkan Kode Tiket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
