@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    {{-- Search Bar --}}
    <div class="starline-card p-4 shadow-xs">
        <form action="{{ route('tracker.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
            <div class="relative flex-1">
                <input
                    type="text"
                    name="code"
                    value="{{ $receipt }}"
                    placeholder="Contoh: HWR-PKH-2610-DEMO01"
                    required
                    class="input-starline w-full font-mono uppercase text-xs sm:text-sm"
                >
            </div>
            <button
                type="submit"
                class="btn-starline-primary shrink-0 text-xs font-bold"
            >
                <svg class="w-4 h-4 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Lacak Resi
            </button>
        </form>
    </div>

    @if(!$shipment)
        {{-- Not Found State --}}
        <div class="starline-card p-8 sm:p-10 text-center space-y-4 rounded-2xl">
            <div class="w-12 h-12 rounded-full bg-slate-900 text-[#e6ff94] mx-auto flex items-center justify-center font-bold text-xl font-mono">
                ?
            </div>
            <div class="space-y-1">
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 font-display">Resi Tidak Ditemukan</h1>
                <p class="text-xs sm:text-sm text-slate-600 max-w-md mx-auto">
                    Nomor resi <span class="font-mono font-bold text-slate-900">{{ $receipt }}</span> tidak terdaftar dalam sistem.
                </p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4 border border-slate-200 max-w-md mx-auto text-left text-xs text-slate-600 space-y-1.5">
                <p class="font-bold text-slate-900">Petunjuk Pengecekan:</p>
                <ul class="list-disc pl-4 space-y-1 text-[11px]">
                    <li>Format: <code>HWR-[PROGRAM]-[YYMM]-[KODE]</code>.</li>
                    <li>Periksa huruf kapital lembar bansos Anda.</li>
                </ul>
            </div>
            <div class="pt-2">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Resi Demo:</span>
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO01']) }}" class="text-xs font-mono font-bold text-slate-900 bg-white hover:bg-[#e6ff94] px-3 py-1.5 rounded-full border border-slate-200 transition-colors shadow-2xs">
                        HWR-PKH-2610-DEMO01
                    </a>
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-BPNT-2610-DEMO02']) }}" class="text-xs font-mono font-bold text-slate-900 bg-white hover:bg-[#e6ff94] px-3 py-1.5 rounded-full border border-slate-200 transition-colors shadow-2xs">
                        HWR-BPNT-2610-DEMO02
                    </a>
                    <a href="{{ route('tracker.show', ['receipt' => 'HWR-PKH-2610-DEMO03']) }}" class="text-xs font-mono font-bold text-slate-900 bg-white hover:bg-[#e6ff94] px-3 py-1.5 rounded-full border border-slate-200 transition-colors shadow-2xs">
                        HWR-PKH-2610-DEMO03
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Found State --}}
        <div class="space-y-6">
            {{-- Summary Card --}}
            <div class="starline-card p-6 rounded-2xl space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center rounded-full bg-slate-900 text-[#e6ff94] px-2.5 py-0.5 text-[10px] font-bold font-mono">
                                {{ $shipment->program->code }}
                            </span>
                            <span class="text-xs text-slate-400 font-mono">Periode: {{ $shipment->period }}</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-mono tracking-tight mt-1">
                            {{ $shipment->receipt_code }}
                        </h1>
                    </div>
                    <div>
                        <span class="inline-flex items-center rounded-full px-3.5 py-1 text-xs font-bold border {{ $shipment->current_status->badgeClass() }}">
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
                    <button type="button" @click="copyResi()" class="btn-starline-ghost text-xs">
                        Salin Resi
                    </button>
                    <button type="button" @click="shareLink()" class="btn-starline-ghost text-xs">
                        Bagikan
                    </button>
                    <button type="button" onclick="window.print()" class="btn-starline-ghost text-xs">
                        Cetak Bukti
                    </button>
                    <a href="{{ route('report.extortion.create', ['resi' => $shipment->receipt_code]) }}" class="btn-starline-primary text-xs font-bold ml-auto">
                        Lapor Masalah &rarr;
                    </a>
                </div>

                {{-- Key Facts Strip --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 border-t border-slate-100 pt-3 text-xs">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-mono block">Program Resmi</span>
                        <span class="font-bold text-slate-900">{{ $shipment->program->name }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-mono block">Instansi Penyalur</span>
                        <span class="font-bold text-slate-900">{{ $shipment->agency->name }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase font-mono block">Titik Salur</span>
                        <span class="font-bold text-slate-900">{{ $shipment->distribution_point ?? 'Lokasi Ditentukan Instansi' }}</span>
                    </div>
                </div>
            </div>

            {{-- Entitlement Card (Rincian Hak Warga) --}}
            <div class="starline-card p-6 rounded-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 font-display">
                            Rincian Hak
                        </h2>
                    </div>
                    <span class="text-[10px] font-bold text-slate-900 bg-[#e6ff94] px-2.5 py-1 rounded-full font-mono shadow-2xs">
                        Wajib Utuh
                    </span>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50 text-[11px] text-slate-500 uppercase tracking-wider font-mono">
                                <th class="py-2.5 px-3">Komponen</th>
                                <th class="py-2.5 px-3">Keterangan</th>
                                <th class="py-2.5 px-3 text-right">Nilai Hak Resmi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-mono">
                            @if($shipment->entitled_cash > 0)
                            <tr>
                                <td class="py-2.5 px-3 font-sans font-bold text-slate-900">Uang Tunai Bansos</td>
                                <td class="py-2.5 px-3 font-sans text-slate-500 text-[11px]">Penyerahan Tunai</td>
                                <td class="py-2.5 px-3 font-bold text-slate-900 text-right tabular-nums">
                                    {{ \App\Support\Money::format($shipment->entitled_cash) }}
                                </td>
                            </tr>
                            @endif

                            @if($shipment->entitled_goods_value > 0 || $shipment->entitled_goods_description)
                            <tr>
                                <td class="py-2.5 px-3 font-sans font-bold text-slate-900">Sembako</td>
                                <td class="py-2.5 px-3 font-sans text-slate-500 text-[11px]">{{ $shipment->entitled_goods_description ?? 'Sembako Sesuai Ketentuan' }}</td>
                                <td class="py-2.5 px-3 font-bold text-slate-900 text-right tabular-nums">
                                    {{ \App\Support\Money::format($shipment->entitled_goods_value) }}
                                </td>
                            </tr>
                            @endif

                            <tr class="bg-slate-50 font-bold border-t-2 border-slate-200 text-slate-900">
                                <td colspan="2" class="py-2.5 px-3 font-sans">Total Nilai Hak</td>
                                <td class="py-2.5 px-3 text-right font-extrabold text-sm text-slate-900 tabular-nums">
                                    {{ \App\Support\Money::format($shipment->entitled_cash + $shipment->entitled_goods_value) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 5-Stage Stepper Timeline --}}
            <div class="starline-card p-6 rounded-2xl space-y-4">
                <h2 class="text-base font-bold text-slate-900 font-display">Linimasa 5 Tahap Penyaluran</h2>

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

                <ol class="relative border-l-2 border-slate-200 ml-3.5 space-y-6 my-2" aria-label="Linimasa Tahapan">
                    @foreach($allStatuses as $statusEnum)
                        @php
                            $stepNum = $statusEnum->stepNumber();
                            $event = $eventsByStatus->get($statusEnum->value);
                            $isDone = $stepNum < $currentStepNum || ($stepNum === $currentStepNum && $event);
                            $isCurrent = $stepNum === $currentStepNum;
                        @endphp
                        <li class="ml-5 relative">
                            @if($isCurrent)
                                <span class="absolute -left-[31px] flex items-center justify-center w-6 h-6 rounded-full bg-[#e6ff94] text-slate-950 ring-4 ring-[#f0f4f8] font-bold text-[11px] font-mono shadow-xs" aria-current="step">
                                    {{ $stepNum }}
                                </span>
                            @elseif($isDone)
                                <span class="absolute -left-[31px] flex items-center justify-center w-6 h-6 rounded-full bg-slate-900 text-white ring-4 ring-[#f0f4f8] font-bold text-[10px]">
                                    &check;
                                </span>
                            @else
                                <span class="absolute -left-[31px] flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-500 ring-4 ring-[#f0f4f8] font-bold text-[11px] font-mono">
                                    {{ $stepNum }}
                                </span>
                            @endif

                            <div class="space-y-0.5 p-2 rounded-xl {{ $isCurrent ? 'bg-white shadow-2xs border border-slate-200' : '' }}">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xs font-bold text-slate-900">
                                        Tahap {{ $stepNum }}: {{ $statusEnum->label() }}
                                    </h3>
                                    @if($event)
                                        <time datetime="{{ $event->occurred_at->toIso8601String() }}" class="text-[10px] text-slate-400 font-mono">
                                            {{ $event->occurred_at->translatedFormat('d M Y, H:i') }}
                                        </time>
                                    @endif
                                </div>

                                @if($event)
                                    <p class="text-[11px] text-slate-600 leading-relaxed">
                                        {{ $event->note ?? 'Tercatat dalam sistem.' }}
                                    </p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- Recipient & Distribution Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="starline-card p-5 rounded-2xl space-y-2">
                    <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono">Data Penerima</h2>
                    <dl class="text-xs space-y-2">
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <dt class="text-slate-400">Nama</dt>
                            <dd class="font-bold font-mono text-slate-900">{{ $shipment->beneficiary->masked_name }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <dt class="text-slate-400">Alamat</dt>
                            <dd class="text-slate-700">{{ $shipment->beneficiary->masked_address ?? 'RT/RW Pilot' }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-1">
                            <dt class="text-slate-400">Wilayah</dt>
                            <dd class="text-slate-700">{{ $shipment->beneficiary->region->name ?? 'Terdaftar' }}</dd>
                        </div>
                        <div class="flex justify-between pt-0.5">
                            <dt class="text-slate-400">Titik Salur</dt>
                            <dd class="font-bold text-slate-900">{{ $shipment->distribution_point ?? 'Ditentukan Penyalur' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="starline-card p-5 rounded-2xl space-y-2 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono">Privasi UU PDP</h2>
                        <p class="text-[11px] text-slate-500 leading-relaxed mt-1">
                            Sesuai UU PDP No. 27/2022, NIK warga dilindungi dengan enkripsi satu arah HMAC-SHA256 ber-pepper rahasia. Tidak ada NIK mentah yang disimpan.
                        </p>
                    </div>
                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-[10px] font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full font-mono">
                            Data Terlindungi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
