@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    {{-- Top Search Bar for quick search --}}
    <div class="hw-card p-4 rounded-xl shadow-xs">
        <form action="{{ route('tracker.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
            <div class="relative flex-1">
                <input
                    type="text"
                    name="code"
                    value="{{ $receipt }}"
                    placeholder="Contoh: HWR-PKH-2610-DEMO01"
                    required
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-3.5 py-2 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-700 font-mono uppercase min-h-[44px]"
                >
            </div>
            <button
                type="submit"
                class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 px-5 py-2 text-sm font-semibold text-white shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-900 min-h-[44px]"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari Resi Lain
            </button>
        </form>
    </div>

    @if(!$shipment)
        {{-- Not Found State --}}
        <div class="hw-card p-8 sm:p-10 text-center space-y-5 rounded-2xl">
            <div class="w-14 h-14 rounded-full bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-400 mx-auto flex items-center justify-center font-bold text-2xl">
                ?
            </div>
            <div class="space-y-1">
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white font-display">Resi Tidak Ditemukan</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400 max-w-md mx-auto">
                    Nomor resi <span class="font-mono font-bold text-slate-900 dark:text-white">{{ $receipt }}</span> belum tercatat dalam basis data penyaluran resmi.
                </p>
            </div>
            <div class="rounded-xl bg-slate-50 dark:bg-slate-800/60 p-4 border border-slate-200 dark:border-slate-700 max-w-lg mx-auto text-left text-xs text-slate-600 dark:text-slate-400 space-y-2">
                <p class="font-bold text-slate-900 dark:text-white">Petunjuk Pengecekan:</p>
                <ul class="list-disc pl-4 space-y-1">
                    <li>Pastikan penulisan sesuai format: <code>HWR-[PROGRAM]-[TAHUN_BULAN]-[KODE_UNIK]</code>.</li>
                    <li>Periksa kembali huruf dan angka pada lembar undangan bansos Anda.</li>
                    <li>Bantuan yang belum dijadwalkan oleh dinas sosial setempat belum memiliki nomor resi.</li>
                </ul>
            </div>
            <div class="pt-2">
                <span class="text-xs text-slate-500 block mb-2 font-medium">Uji coba dengan nomor resi simulasi resmi:</span>
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO01']) }}" class="text-xs font-mono font-bold text-teal-800 dark:text-teal-400 bg-teal-50 dark:bg-teal-950/70 hover:bg-teal-100 dark:hover:bg-teal-900 px-3 py-1.5 rounded-lg border border-teal-200 dark:border-teal-800">
                        HWR-PKH-2610-DEMO01
                    </a>
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-BPNT-2610-DEMO02']) }}" class="text-xs font-mono font-bold text-teal-800 dark:text-teal-400 bg-teal-50 dark:bg-teal-950/70 hover:bg-teal-100 dark:hover:bg-teal-900 px-3 py-1.5 rounded-lg border border-teal-200 dark:border-teal-800">
                        HWR-BPNT-2610-DEMO02
                    </a>
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO03']) }}" class="text-xs font-mono font-bold text-teal-800 dark:text-teal-400 bg-teal-50 dark:bg-teal-950/70 hover:bg-teal-100 dark:hover:bg-teal-900 px-3 py-1.5 rounded-lg border border-teal-200 dark:border-teal-800">
                        HWR-PKH-2610-DEMO03
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Found State --}}
        <div class="space-y-6">
            {{-- Summary Card --}}
            <div class="hw-card p-6 rounded-2xl space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center rounded-md bg-teal-100 dark:bg-teal-950 text-teal-800 dark:text-teal-300 px-2.5 py-0.5 text-xs font-bold font-display">
                                {{ $shipment->program->code }}
                            </span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Periode Alokasi: {{ $shipment->period }}</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white font-mono tracking-tight mt-1">
                            {{ $shipment->receipt_code }}
                        </h1>
                    </div>
                    <div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold border {{ $shipment->current_status->badgeClass() }}">
                            Tahap {{ $shipment->current_status->stepNumber() }} dari 5: {{ $shipment->current_status->label() }}
                        </span>
                    </div>
                </div>

                {{-- Action Strip --}}
                <div class="flex flex-wrap items-center gap-2 pt-1 print:hidden"
                     x-data="{
                         copyResi() {
                             navigator.clipboard.writeText('{{ $shipment->receipt_code }}');
                             window.hwToast('Nomor resi berhasil disalin!');
                         },
                         shareLink() {
                             navigator.clipboard.writeText(window.location.href);
                             window.hwToast('Tautan pelacakan berhasil disalin!');
                         }
                     }">
                    <button type="button" @click="copyResi()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 min-h-[38px] transition-colors">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Salin Nomor Resi
                    </button>
                    <button type="button" @click="shareLink()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 min-h-[38px] transition-colors">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        Bagikan Tautan
                    </button>
                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 min-h-[38px] transition-colors">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Cetak Kartu Hak
                    </button>
                    <a href="{{ route('report.extortion.create', ['resi' => $shipment->receipt_code]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 dark:bg-amber-950/60 border border-amber-300 dark:border-amber-800 text-xs font-bold text-amber-900 dark:text-amber-200 hover:bg-amber-100 min-h-[38px] ml-auto transition-colors">
                        <svg class="w-3.5 h-3.5 text-amber-700 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Laporkan Masalah Resi Ini
                    </a>
                </div>

                {{-- Key Facts Strip --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm border-t border-slate-100 dark:border-slate-800 pt-4">
                    <div>
                        <span class="text-xs text-slate-500 dark:text-slate-400 block">Program Resmi</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $shipment->program->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 dark:text-slate-400 block">Instansi Pelaksana</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $shipment->agency->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 dark:text-slate-400 block">Titik Distribusi Salur</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $shipment->distribution_point ?? 'Lokasi Ditentukan Instansi' }}</span>
                    </div>
                </div>
            </div>

            {{-- Entitlement Card (Rincian Hak Warga) --}}
            <div class="hw-card p-6 rounded-2xl border-2 border-teal-700/30 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white font-display flex items-center gap-2">
                            Rincian Hak Bantuan Sosial
                        </h2>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
                            Hak sah penerima manfaat yang wajib diserahkan utuh di lokasi salur tanpa potongan apa pun.
                        </p>
                    </div>
                    <span class="text-xs font-bold text-teal-800 dark:text-teal-300 bg-teal-50 dark:bg-teal-950 px-2.5 py-1 rounded-md border border-teal-200 dark:border-teal-800 shrink-0">
                        Wajib Diterima Utuh
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                <th class="py-2.5 font-semibold">Komponen Hak</th>
                                <th class="py-2.5 font-semibold">Keterangan Komoditas</th>
                                <th class="py-2.5 font-semibold text-right">Nilai Hak Resmi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @if($shipment->entitled_cash > 0)
                            <tr>
                                <td class="py-3 font-semibold text-slate-900 dark:text-white">Uang Tunai Bansos</td>
                                <td class="py-3 text-xs text-slate-600 dark:text-slate-400">Diserahkan langsung tunai via juru bayar kantor pos / bank penyalur</td>
                                <td class="py-3 font-mono font-bold text-slate-900 dark:text-white text-right tabular-nums">
                                    {{ \App\Support\Money::format($shipment->entitled_cash) }}
                                </td>
                            </tr>
                            @endif

                            @if($shipment->entitled_goods_value > 0 || $shipment->entitled_goods_description)
                            <tr>
                                <td class="py-3 font-semibold text-slate-900 dark:text-white">Komoditas Barang Sembako</td>
                                <td class="py-3 text-xs text-slate-600 dark:text-slate-400">{{ $shipment->entitled_goods_description ?? 'Sembako Sesuai Ketentuan' }}</td>
                                <td class="py-3 font-mono font-bold text-slate-900 dark:text-white text-right tabular-nums">
                                    {{ \App\Support\Money::format($shipment->entitled_goods_value) }}
                                </td>
                            </tr>
                            @endif

                            <tr class="bg-teal-50/60 dark:bg-teal-950/40 font-bold border-t-2 border-slate-200 dark:border-slate-800">
                                <td colspan="2" class="py-3 text-slate-900 dark:text-white text-sm">Total Nilai Hak Penerima</td>
                                <td class="py-3 text-right font-mono text-base text-teal-800 dark:text-teal-300 tabular-nums">
                                    {{ \App\Support\Money::format($shipment->entitled_cash + $shipment->entitled_goods_value) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="rounded-lg bg-amber-50 dark:bg-amber-950/60 p-3 border border-amber-200 dark:border-amber-800 text-xs text-amber-900 dark:text-amber-200 space-y-1">
                    <p class="font-bold">Ketentuan Bebas Biaya:</p>
                    <p>
                        Penyaluran bantuan sosial resmi tidak dipungut biaya administrasi, iuran desa, tebus sembako, atau potongan dalam bentuk apa pun.
                    </p>
                </div>
            </div>

            {{-- 5-Stage Vertical Stepper Timeline --}}
            <div class="hw-card p-6 rounded-2xl space-y-6">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white font-display">Linimasa 5 Tahap Penyaluran</h2>
                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
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

                <ol class="relative border-l-2 border-slate-200 dark:border-slate-800 ml-4 space-y-8" aria-label="Linimasa Tahapan">
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
                                <span class="absolute -left-[35px] flex items-center justify-center w-7 h-7 rounded-full bg-teal-700 text-white ring-4 ring-white dark:ring-slate-900 font-bold text-xs" aria-current="step">
                                    {{ $stepNum }}
                                </span>
                            @elseif($isDone)
                                <span class="absolute -left-[35px] flex items-center justify-center w-7 h-7 rounded-full bg-emerald-600 text-white ring-4 ring-white dark:ring-slate-900 font-bold text-xs">
                                    &check;
                                </span>
                            @else
                                <span class="absolute -left-[35px] flex items-center justify-center w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 ring-4 ring-white dark:ring-slate-900 font-bold text-xs">
                                    {{ $stepNum }}
                                </span>
                            @endif

                            {{-- Step Details --}}
                            <div class="space-y-1 p-2 rounded-lg {{ $isCurrent ? 'bg-teal-50/50 dark:bg-teal-950/30 border border-teal-200 dark:border-teal-800' : '' }}">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                    <h3 class="text-sm font-bold text-slate-900 dark:text-white font-display">
                                        Tahap {{ $stepNum }}: {{ $statusEnum->label() }}
                                    </h3>
                                    @if($event)
                                        <time datetime="{{ $event->occurred_at->toIso8601String() }}" class="text-xs text-slate-500 dark:text-slate-400 font-mono">
                                            {{ $event->occurred_at->translatedFormat('d M Y, H:i') }} WIB
                                        </time>
                                    @else
                                        <span class="text-xs text-slate-400 font-medium">Menunggu Pelaksanaan</span>
                                    @endif
                                </div>

                                @if($event)
                                    <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed">
                                        {{ $event->note ?? 'Tahapan telah dicatat oleh sistem.' }}
                                    </p>
                                    @if($event->agency)
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">
                                            Dicatat oleh: <span class="font-medium text-slate-700 dark:text-slate-300">{{ $event->agency->name }}</span>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-[11px] text-slate-400 italic">
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
                <div class="hw-card p-6 rounded-2xl space-y-3">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white font-display">Penerima &amp; Lokasi Distribusi</h2>
                    <dl class="text-xs sm:text-sm space-y-2.5">
                        <div class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-1.5">
                            <dt class="text-slate-500">Nama Penerima</dt>
                            <dd class="font-bold text-slate-900 dark:text-white font-mono">{{ $shipment->beneficiary->masked_name }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-1.5">
                            <dt class="text-slate-500">Alamat Tinggal</dt>
                            <dd class="text-slate-800 dark:text-slate-200">{{ $shipment->beneficiary->masked_address ?? 'RT/RW Wilayah Pilot' }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-1.5">
                            <dt class="text-slate-500">Wilayah Kelurahan</dt>
                            <dd class="text-slate-800 dark:text-slate-200">{{ $shipment->beneficiary->region->name ?? 'Wilayah Terdaftar' }}</dd>
                        </div>
                        <div class="flex justify-between pt-1">
                            <dt class="text-slate-500">Titik Salur Resmi</dt>
                            <dd class="font-semibold text-teal-800 dark:text-teal-400">{{ $shipment->distribution_point ?? 'Ditentukan Penyalur' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="hw-card p-6 rounded-2xl space-y-3 flex flex-col justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white font-display">Perlindungan Privasi Warga</h2>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mt-2">
                            Berdasarkan kepatuhan UU Perlindungan Data Pribadi No. 27/2022, NIK warga tidak pernah disimpan dalam format teks mentah. Sistem ini menerapkan enkripsi satu arah HMAC-SHA256 ber-garam rahasia (pepper) agar data kependudukan terlindungi seutuhnya.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                        <span class="inline-flex items-center gap-1.5 text-xs text-emerald-800 dark:text-emerald-400 font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            Data Pribadi Terlindungi &amp; Ter-masking
                        </span>
                    </div>
                </div>
            </div>

            {{-- CTA Report Discrepancy --}}
            <div class="bg-slate-900 text-white rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <h2 class="text-base font-bold font-display text-white">Ada Potongan Liar atau Selisih Bantuan?</h2>
                    <p class="text-xs text-slate-300">
                        Laporkan secara anonim tanpa identitas pelapor. Laporan Anda tercatat dengan kode rahasia berkeadilan.
                    </p>
                </div>
                <div>
                    <a href="{{ route('report.extortion.create', ['resi' => $shipment->receipt_code]) }}" class="inline-flex items-center justify-center rounded-lg bg-teal-600 hover:bg-teal-500 px-5 py-2.5 text-xs font-bold text-white min-h-[44px] whitespace-nowrap focus:outline-none focus-visible:ring-2 focus-visible:ring-white shadow-xs transition-colors">
                        Buat Laporan Tanpa Identitas
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
