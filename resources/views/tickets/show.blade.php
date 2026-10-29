@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('ticket.index') }}" class="inline-flex items-center text-xs text-teal-800 hover:underline font-medium">
            &larr; Cari nomor tiket lain
        </a>
        @if($isAuthorized)
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                Sesi Pelapor Terverifikasi
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 border border-slate-200 text-xs font-medium">
                Tampilan Status Publik
            </span>
        @endif
    </div>

    @if(!$report)
        <div class="bg-white rounded-xl border border-slate-200 p-8 text-center space-y-4">
            <h1 class="text-xl font-bold text-slate-900 font-display">Tiket Tidak Ditemukan</h1>
            <p class="text-sm text-slate-600">
                Nomor tiket <span class="font-mono font-semibold">{{ $ticket }}</span> tidak terdaftar dalam sistem.
            </p>
            <div class="pt-2">
                <a href="{{ route('ticket.index') }}" class="inline-flex items-center justify-center rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800 min-h-[44px]">
                    Coba Nomor Tiket Lain
                </a>
            </div>
        </div>
    @else
        {{-- Status Header Card --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                <div>
                    <span class="text-xs text-slate-500 font-medium">Nomor Tiket Aduan</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 font-mono tracking-tight mt-0.5">
                        {{ $report->ticket_code }}
                    </h1>
                </div>
                <div>
                    <span class="inline-flex items-center rounded-full px-3.5 py-1 text-xs font-semibold border {{ $report->status->badgeClass() }}">
                        Status: {{ $report->status->label() }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-xs text-slate-500 block">Jenis Laporan</span>
                    <span class="font-semibold text-slate-800">{{ $report->type->label() }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Wilayah Kejadian</span>
                    <span class="font-semibold text-slate-800">{{ $report->region->name }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Waktu Pengiriman</span>
                    <span class="font-semibold text-slate-800">{{ $report->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                </div>
            </div>
        </div>

        @if($isAuthorized)
            {{-- Authorized Full View --}}
            <div class="space-y-6">
                {{-- Detail Isi Aduan --}}
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
                    <h2 class="text-base font-bold text-slate-900 font-display">Rincian Laporan Anda</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm bg-slate-50 p-4 rounded-lg border border-slate-200">
                        <div>
                            <dt class="text-xs text-slate-500">Kategori</dt>
                            <dd class="font-medium text-slate-800 mt-0.5">{{ $report->category }}</dd>
                        </div>
                        @if($report->amount_claimed)
                        <div>
                            <dt class="text-xs text-slate-500">Nominal Pemotongan</dt>
                            <dd class="font-mono font-bold text-slate-900 mt-0.5">{{ \App\Support\Money::format($report->amount_claimed) }}</dd>
                        </div>
                        @endif
                    </dl>
                    <div>
                        <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Uraian Kejadian:</h3>
                        <div class="rounded-lg bg-slate-50 p-4 border border-slate-200 text-sm text-slate-800 whitespace-pre-line leading-relaxed">
                            {{ $report->description }}
                        </div>
                    </div>
                </div>

                {{-- Riwayat Tindak Lanjut & Audit Trail --}}
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
                    <h2 class="text-base font-bold text-slate-900 font-display">Riwayat Tindak Lanjut &amp; Tanggapan Staf</h2>
                    <div class="space-y-4">
                        @forelse($report->updates as $update)
                            <div class="border-l-2 border-teal-700 pl-4 py-1 space-y-1">
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="font-semibold text-teal-800">{{ $update->status->label() }}</span>
                                    <span>{{ $update->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                </div>
                                <p class="text-sm text-slate-800 leading-relaxed">{{ $update->message }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 italic">Belum ada pembaruan dari petugas penelaah.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Form Kirim Tanggapan Tambahan --}}
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
                    <h2 class="text-base font-bold text-slate-900 font-display">Kirim Tanggapan atau Bukti Tambahan</h2>
                    <p class="text-xs text-slate-600">
                        Anda dapat menambahkan informasi susulan atau mengklarifikasi tanggapan staf melalui form di bawah ini.
                    </p>

                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-md p-3 text-xs">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('ticket.reply', ['ticket' => $report->ticket_code]) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <textarea
                                name="message"
                                rows="3"
                                required
                                placeholder="Tuliskan keterangan tambahan atau jawaban atas tindak lanjut staf..."
                                class="w-full rounded-md border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700"
                            ></textarea>
                        </div>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-md bg-teal-700 px-5 py-2 text-sm font-semibold text-white hover:bg-teal-800 min-h-[44px]"
                        >
                            Kirim Keterangan Tambahan
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- Unauthorized: Secret Code Required --}}
            <div class="bg-white rounded-xl border-2 border-amber-300 p-6 sm:p-8 space-y-5">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-sm shrink-0">
                        !
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-base font-bold text-slate-900 font-display">Buka Rincian Isi Laporan dengan Kode Rahasia</h2>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Demi melindungi data pelapor, isi aduan dan tanggapan lengkap dirahasiakan dari publik. Masukkan kode rahasia 12 karakter Anda untuk membuka interaksi penuh.
                        </p>
                    </div>
                </div>

                @if($errors->has('auth'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-900 rounded-md p-3 text-xs">
                        {{ $errors->first('auth') }}
                    </div>
                @endif

                <form action="{{ route('ticket.access') }}" method="POST" class="flex flex-col sm:flex-row gap-2 pt-2">
                    @csrf
                    <input type="hidden" name="ticket_code" value="{{ $report->ticket_code }}">
                    <div class="flex-1">
                        <input
                            type="text"
                            name="secret_code"
                            placeholder="Masukkan Kode Rahasia (Contoh: 4HX7-9K2M-P8Q3)"
                            required
                            class="w-full rounded-md border border-slate-300 px-3.5 py-2 text-sm text-slate-900 font-mono uppercase focus:border-teal-700 focus:ring-2 focus:ring-teal-700 min-h-[44px]"
                        >
                    </div>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-teal-700 px-6 py-2 text-sm font-semibold text-white hover:bg-teal-800 min-h-[44px]"
                    >
                        Buka Laporan
                    </button>
                </form>
            </div>
        @endif
    @endif
</div>
@endsection
