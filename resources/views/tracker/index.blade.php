@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <div class="text-center space-y-2">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Lacak Resi Penyaluran Bantuan Sosial
        </h1>
        <p class="text-sm text-slate-600 max-w-xl mx-auto">
            Gunakan nomor resi penyaluran resmi untuk melihat status distribusi terkini, instansi pelaksana, dan rincian hak bantuan Anda.
        </p>
    </div>

    {{-- Search Form Box --}}
    <div class="bg-white p-6 sm:p-8 rounded-xl border border-slate-200 shadow-sm">
        <form action="{{ route('tracker.index') }}" method="GET" class="space-y-4">
            <div>
                <label for="receipt-code-input" class="block text-sm font-semibold text-slate-900 mb-1.5">
                    Nomor Resi Penyaluran
                </label>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input
                        type="text"
                        id="receipt-code-input"
                        name="code"
                        placeholder="HWR-PKH-2610-DEMO01"
                        required
                        autofocus
                        class="w-full rounded-md border border-slate-300 px-3.5 py-2.5 text-base text-slate-900 placeholder:text-slate-400 focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-700 font-mono uppercase min-h-[44px]"
                    >
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-teal-700 px-6 py-2.5 text-base font-semibold text-white hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-900 min-h-[44px]"
                    >
                        Periksa Resi
                    </button>
                </div>
                <p class="text-xs text-slate-500 mt-2">
                    Kombinasi huruf dan angka kapital sesuai surat pemberitahuan dari dinas sosial atau PT Pos Indonesia.
                </p>
            </div>
        </form>

        {{-- Demo Options --}}
        <div class="pt-6 mt-6 border-t border-slate-100">
            <span class="text-xs font-semibold text-slate-700 block mb-2">Pilih Data Simulasi untuk Menguji:</span>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO01']) }}" class="p-3 rounded-lg border border-slate-200 hover:border-teal-700 hover:bg-teal-50/30 text-left transition-colors">
                    <span class="block text-xs font-mono font-bold text-teal-800">HWR-PKH-2610-DEMO01</span>
                    <span class="block text-[11px] text-slate-600 mt-0.5">PKH - Dalam Pengiriman</span>
                </a>
                <a href="{{ route('tracker.show', ['receipt' => 'HWR-BPNT-2610-DEMO02']) }}" class="p-3 rounded-lg border border-slate-200 hover:border-teal-700 hover:bg-teal-50/30 text-left transition-colors">
                    <span class="block text-xs font-mono font-bold text-teal-800">HWR-BPNT-2610-DEMO02</span>
                    <span class="block text-[11px] text-slate-600 mt-0.5">BPNT - Penjadwalan</span>
                </a>
                <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO03']) }}" class="p-3 rounded-lg border border-slate-200 hover:border-teal-700 hover:bg-teal-50/30 text-left transition-colors">
                    <span class="block text-xs font-mono font-bold text-teal-800">HWR-PKH-2610-DEMO03</span>
                    <span class="block text-[11px] text-slate-600 mt-0.5">PKH - Selesai di Titik Salur</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Privacy Notice --}}
    <div class="rounded-lg bg-slate-100 p-4 border border-slate-200 text-xs text-slate-600 space-y-1">
        <p class="font-semibold text-slate-800">Kebijakan Privasi Nomor Induk Kependudukan (NIK)</p>
        <p>
            HakWarga tidak menyediakan fitur pencarian menggunakan NIK mentah secara terbuka. Hal ini bertujuan mencegah kebocoran informasi finansial dan profiling sepihak terhadap warga penerima bantuan sosial.
        </p>
    </div>
</div>
@endsection
