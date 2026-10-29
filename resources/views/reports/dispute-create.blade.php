@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <div class="space-y-2">
        <a href="{{ route('report.choose') }}" class="inline-flex items-center text-xs text-teal-800 hover:underline font-medium">
            &larr; Kembali ke pilihan laporan
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Form Sanggah Kelayakan Penerima Bantuan Sosial
        </h1>
        <p class="text-sm text-slate-600 leading-relaxed">
            Sanggahan Anda membantu memastikan kuota bantuan sosial disalurkan tepat sasaran kepada keluarga yang benar-benar membutuhkan.
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
        <form action="{{ route('report.dispute.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Honeypot anti-bot --}}
            <div class="hidden" aria-hidden="true">
                <label for="honeypot-dispute">Jangan isi bidang ini</label>
                <input type="text" id="honeypot-dispute" name="honeypot" tabindex="-1" autocomplete="off">
            </div>

            {{-- Wilayah --}}
            <div>
                <label for="region-select-dispute" class="block text-sm font-semibold text-slate-900 mb-1">
                    Wilayah Kelurahan / Desa Penerima <span class="text-rose-600">*</span>
                </label>
                <select id="region-select-dispute" name="region_id" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[44px]">
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
                <label for="program-select" class="block text-sm font-semibold text-slate-900 mb-1">
                    Program Bantuan Sosial <span class="text-rose-600">*</span>
                </label>
                <select id="program-select" name="program_id" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[44px]">
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
                <label for="category-select-dispute" class="block text-sm font-semibold text-slate-900 mb-1">
                    Alasan Sanggah Kelayakan <span class="text-rose-600">*</span>
                </label>
                <select id="category-select-dispute" name="category" required class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[44px]">
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
                <label for="target-name-input" class="block text-sm font-semibold text-slate-900 mb-1">
                    Nama Warga / Kepala Keluarga yang Disanggah <span class="text-rose-600">*</span>
                </label>
                <input
                    type="text"
                    id="target-name-input"
                    name="target_beneficiary_name"
                    value="{{ old('target_beneficiary_name') }}"
                    placeholder="Contoh: Budi Santoso (RT 02/RW 03)"
                    required
                    class="w-full rounded-md border border-slate-300 px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[44px]"
                >
            </div>

            {{-- Uraian Sanggahan --}}
            <div>
                <label for="dispute-description-input" class="block text-sm font-semibold text-slate-900 mb-1">
                    Uraian Fakta Lapangan <span class="text-rose-600">*</span>
                </label>
                <textarea
                    id="dispute-description-input"
                    name="description"
                    rows="5"
                    required
                    placeholder="Jelaskan kondisi ekonomi riil, kepemilikan aset, atau bukti pendukung mengapa warga tersebut tidak memenuhi kriteria bansos..."
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
                    Kirim Sanggahan &amp; Dapatkan Kode Tiket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
