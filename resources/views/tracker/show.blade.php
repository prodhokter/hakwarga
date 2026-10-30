@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    {{-- Top Search Bar for quick search --}}
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
        <form action="{{ route('tracker.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
            <div class="relative flex-1">
                <input
                    type="text"
                    name="code"
                    value="{{ $receipt }}"
                    placeholder="Contoh: HWR-PKH-2610-DEMO01"
                    required
                    class="w-full rounded-md border border-slate-300 px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-700 font-mono uppercase min-h-[44px]"
                >
            </div>
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-md bg-teal-700 px-5 py-2 text-sm font-semibold text-white hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-900 min-h-[44px]"
            >
                Cari Resi Lain
            </button>
        </form>
    </div>

    @if(!$shipment)
        {{-- Not Found State --}}
        <div class="bg-white rounded-xl border border-slate-200 p-8 text-center space-y-4">
            <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-700 mx-auto flex items-center justify-center font-bold text-xl">
                ?
            </div>
            <div class="space-y-1">
                <h1 class="text-xl font-bold text-slate-900 font-display">Resi Tidak Ditemukan</h1>
                <p class="text-sm text-slate-600 max-w-md mx-auto">
                    Nomor resi <span class="font-mono font-semibold text-slate-900">{{ $receipt }}</span> tidak terdaftar dalam basis data penyaluran resmi.
                </p>
            </div>
            <div class="rounded-lg bg-slate-50 p-4 border border-slate-200 max-w-md mx-auto text-left text-xs text-slate-600 space-y-2">
                <p class="font-semibold text-slate-800">Petunjuk Pengecekan:</p>
                <ul class="list-disc pl-4 space-y-1">
                    <li>Pastikan penulisan sesuai format: <code>HWR-[PROGRAM]-[TAHUN_BULAN]-[KODE_UNIK]</code>.</li>
                    <li>Periksa kembali huruf dan angka pada lembar undangan bansos Anda.</li>
                    <li>Bantuan yang belum dijadwalkan oleh dinas sosial setempat belum memiliki nomor resi.</li>
                </ul>
            </div>
            <div class="pt-2">
                <span class="text-xs text-slate-500 block mb-2">Coba nomor resi simulasi resmi:</span>
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO01']) }}" class="text-xs font-mono font-semibold text-teal-800 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded border border-teal-200">
                        HWR-PKH-2610-DEMO01
                    </a>
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-BPNT-2610-DEMO02']) }}" class="text-xs font-mono font-semibold text-teal-800 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded border border-teal-200">
                        HWR-BPNT-2610-DEMO02
                    </a>
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO03']) }}" class="text-xs font-mono font-semibold text-teal-800 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded border border-teal-200">
                        HWR-PKH-2610-DEMO03
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Found State --}}
        <div class="space-y-6">
            {{-- Summary Card --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center rounded-md bg-teal-100 text-teal-800 px-2 py-0.5 text-xs font-bold font-display">
                                {{ $shipment->program->code }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium">Periode Alokasi: {{ $shipment->period }}</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-mono tracking-tight mt-1">
                            {{ $shipment->receipt_code }}
                        </h1>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-xs print:hidden min-h-[38px]">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Cetak Kartu Hak
                        </button>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold border {{ $shipment->current_status->badgeClass() }}">
                            Tahap {{ $shipment->current_status->stepNumber() }} dari 5: {{ $shipment->current_status->label() }}
                        </span>
                    </div>
                </div>

                {{-- Key Facts Strip --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-xs text-slate-500 block">Program Resmi</span>
                        <span class="font-semibold text-slate-800">{{ $shipment->program->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block">Instansi / Penyalur</span>
                        <span class="font-semibold text-slate-800">{{ $shipment->agency->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block">Titik Distribusi Penyaluran</span>
                        <span class="font-semibold text-slate-800">{{ $shipment->distribution_point ?? 'Lokasi Ditentukan Instansi' }}</span>
                    </div>
                </div>
            </div>

            {{-- Entitlement Card (Rincian Hak Warga) --}}
            <div class="bg-white rounded-xl border-2 border-teal-700/20 p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 font-display flex items-center gap-2">
                            Rincian Hak Bantuan Sosial
                        </h2>
                        <p class="text-xs text-slate-600 mt-0.5">
                            Hak sah penerima manfaat yang wajib diserahkan utuh di lokasi salur tanpa biaya apa pun.
                        </p>
                    </div>
                    <span class="text-xs font-bold text-teal-800 bg-teal-50 px-2.5 py-1 rounded border border-teal-200">
                        Wajib Diterima Utuh
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                                <th class="py-2 font-semibold">Komponen Hak</th>
                                <th class="py-2 font-semibold">Keterangan Komoditas</th>
                                <th class="py-2 font-semibold text-right">Nilai Hak Resmi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @if($shipment->entitled_cash > 0)
                            <tr>
                                <td class="py-3 font-semibold text-slate-900">Uang Tunai Bansos</td>
                                <td class="py-3 text-slate-600">Diserahkan langsung tunai via juru bayar kantor pos/bank</td>
                                <td class="py-3 font-mono font-bold text-slate-900 text-right">
                                    {{ \App\Support\Money::format($shipment->entitled_cash) }}
                                </td>
                            </tr>
                            @endif

                            @if($shipment->entitled_goods_value > 0 || $shipment->entitled_goods_description)
                            <tr>
                                <td class="py-3 font-semibold text-slate-900">Komoditas Barang Sembako</td>
                                <td class="py-3 text-slate-600">{{ $shipment->entitled_goods_description ?? 'Sembako Sesuai Ketentuan' }}</td>
                                <td class="py-3 font-mono font-bold text-slate-900 text-right">
                                    {{ \App\Support\Money::format($shipment->entitled_goods_value) }}
                                </td>
                            </tr>
                            @endif

                            <tr class="bg-teal-50/40 font-bold border-t-2 border-slate-200">
                                <td colspan="2" class="py-3 text-slate-900 text-base">Total Nilai Hak Penerima</td>
                                <td class="py-3 text-right font-mono text-base text-teal-900">
                                    {{ \App\Support\Money::format($shipment->entitled_cash + $shipment->entitled_goods_value) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="rounded-md bg-amber-50 p-3 border border-amber-200 text-xs text-amber-900 space-y-1">
                    <p class="font-semibold">Perlindungan dari Pemotongan Liar:</p>
                    <p>
                        Penyaluran bantuan sosial resmi tidak dipungut biaya administrasi, iuran desa, tebus sembako, atau pemotongan dalam bentuk apa pun.
                    </p>
                </div>
            </div>

            {{-- 5-Stage Vertical Timeline --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 font-display">Linimasa 5 Tahap Penyaluran</h2>
                    <p class="text-xs text-slate-600 mt-0.5">
                        Jejak tahapan resmi dari proses pendataan sampai penyerahan kepada warga penerima manfaat.
                    </p>
                </div>

                @php
                    $allStatuses = [
                        \App\Enums\ShipmentStatus::DataCollected,
                        \App\Enums\ShipmentStatus::EligibilityVerified,
                        \App\Enums\ShipmentStatus::Scheduled,
                        \App\Enums\ShipmentStatus::InDelivery,
                        \App\Enums\ShipmentStatus::ReceivedAtPoint,
                    ];
                    $currentStepNum = $shipment->current_status->stepNumber();
                    $eventsByStatus = $shipment->events->keyBy(fn($e) => $e->status->value);
                @endphp

                <ol class="relative border-l-2 border-slate-200 ml-4 space-y-8" aria-label="Linimasa Tahapan">
                    @foreach($allStatuses as $statusEnum)
                        @php
                            $stepNum = $statusEnum->stepNumber();
                            $event = $eventsByStatus->get($statusEnum->value);
                            $isDone = $stepNum < $currentStepNum || ($stepNum === $currentStepNum && $event);
                            $isCurrent = $stepNum === $currentStepNum;
                        @endphp
                        <li class="ml-6 relative">
                            {{-- Step Marker --}}
                            @if($isCurrent)
                                <span class="absolute -left-[35px] flex items-center justify-center w-7 h-7 rounded-full bg-teal-700 text-white ring-4 ring-white font-bold text-xs" aria-current="step">
                                    {{ $stepNum }}
                                </span>
                            @elseif($isDone)
                                <span class="absolute -left-[35px] flex items-center justify-center w-7 h-7 rounded-full bg-teal-600 text-white ring-4 ring-white font-bold text-xs">
                                    ✓
                                </span>
                            @else
                                <span class="absolute -left-[35px] flex items-center justify-center w-7 h-7 rounded-full bg-slate-200 text-slate-600 ring-4 ring-white font-bold text-xs">
                                    {{ $stepNum }}
                                </span>
                            @endif

                            {{-- Step Details --}}
                            <div class="space-y-1">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                    <h3 class="text-base font-bold text-slate-900 font-display">
                                        Tahap {{ $stepNum }}: {{ $statusEnum->label() }}
                                    </h3>
                                    @if($event)
                                        <time datetime="{{ $event->occurred_at->toIso8601String() }}" class="text-xs text-slate-500 font-mono">
                                            {{ $event->occurred_at->translatedFormat('d M Y, H:i') }} WIB
                                        </time>
                                    @else
                                        <span class="text-xs text-slate-400 font-medium">Menunggu Pelaksanaan</span>
                                    @endif
                                </div>

                                @if($event)
                                    <p class="text-sm text-slate-700 leading-relaxed">
                                        {{ $event->note ?? 'Tahapan telah dicatat oleh sistem.' }}
                                    </p>
                                    @if($event->agency)
                                        <div class="text-xs text-slate-500">
                                            Dicatat oleh: <span class="font-medium text-slate-700">{{ $event->agency->name }}</span>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-xs text-slate-500 italic">
                                        Tahapan ini akan diperbarui segera setelah instansi pelaksana mengunggah konfirmasi lapangan.
                                    </p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- Recipient & Privacy Protection Card --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-3">
                    <h2 class="text-base font-bold text-slate-900 font-display">Penerima &amp; Lokasi Distribusi</h2>
                    <dl class="text-sm space-y-2">
                        <div class="flex justify-between border-b border-slate-100 pb-1.5">
                            <dt class="text-slate-500 text-xs">Nama Penerima</dt>
                            <dd class="font-semibold text-slate-900 font-mono">{{ $shipment->beneficiary->masked_name }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1.5">
                            <dt class="text-slate-500 text-xs">Alamat Tinggal</dt>
                            <dd class="text-slate-800">{{ $shipment->beneficiary->masked_address ?? 'RT/RW Wilayah Pilot' }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1.5">
                            <dt class="text-slate-500 text-xs">Wilayah Kelurahan</dt>
                            <dd class="text-slate-800">{{ $shipment->beneficiary->region->name ?? 'Wilayah Terdaftar' }}</dd>
                        </div>
                        <div class="flex justify-between pt-1">
                            <dt class="text-slate-500 text-xs">Titik Salur Resmi</dt>
                            <dd class="font-medium text-teal-900">{{ $shipment->distribution_point ?? 'Ditentukan Penyalur' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-3 flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 font-display">Perlindungan Privasi Warga</h2>
                        <p class="text-xs text-slate-600 leading-relaxed mt-2">
                            Berdasarkan prinsip kepatuhan UU Perlindungan Data Pribadi No. 27/2022, NIK warga tidak pernah disimpan dalam format teks mentah. Sistem ini menerapkan enkripsi satu arah HMAC-SHA256 ber-garam rahasia (pepper) agar data kependudukan terlindungi seutuhnya.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100">
                        <span class="inline-flex items-center gap-1.5 text-xs text-emerald-800 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            Data Pribadi Terlindungi &amp; Ter-masking
                        </span>
                    </div>
                </div>
            </div>

            {{-- CTA Report Discrepancy --}}
            <div class="bg-slate-900 rounded-xl p-6 text-white flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <h2 class="text-base font-bold font-display text-white">Ada Potongan Liar atau Selisih Bantuan?</h2>
                    <p class="text-xs text-slate-300">
                        Laporkan secara anonim tanpa identitas pelapor. Laporan Anda tercatat dengan kode rahasia berkeadilan.
                    </p>
                </div>
                <div>
                    <a href="{{ route('report.choose') }}" class="inline-flex items-center justify-center rounded-md bg-teal-600 hover:bg-teal-500 px-4 py-2.5 text-xs font-bold text-white min-h-[44px] whitespace-nowrap focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                        Buat Laporan Tanpa Identitas
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
