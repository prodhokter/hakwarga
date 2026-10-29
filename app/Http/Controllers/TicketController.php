<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportUpdate;
use App\Services\PiiMasker;
use App\Services\TicketCodeFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(): View
    {
        return view('tickets.lookup');
    }

    public function access(Request $request, TicketCodeFactory $ticketFactory): RedirectResponse
    {
        $validated = $request->validate([
            'ticket_code' => ['required', 'string'],
            'secret_code' => ['required', 'string'],
        ], [
            'ticket_code.required' => 'Nomor tiket wajib diisi.',
            'secret_code.required' => 'Kode rahasia wajib diisi.',
        ]);

        /** @var string $ticketCodeInput */
        $ticketCodeInput = $validated['ticket_code'];
        /** @var string $secretCodeInput */
        $secretCodeInput = $validated['secret_code'];

        $normalizedTicket = strtoupper(trim($ticketCodeInput));
        $report = Report::where('ticket_code', $normalizedTicket)->first();

        if (! $report || ! $ticketFactory->verifySecret($secretCodeInput, $report->secret_hash)) {
            return back()->withInput()->withErrors([
                'auth' => 'Kombinasi nomor tiket dan kode rahasia tidak cocok atau tidak ditemukan.',
            ]);
        }

        $request->session()->put('authenticated_ticket_'.$report->ticket_code, true);

        return redirect()->route('ticket.show', ['ticket' => $report->ticket_code]);
    }

    public function show(string $ticket, Request $request): View
    {
        $normalizedTicket = strtoupper(trim($ticket));
        $report = Report::with(['region', 'agency', 'program', 'updates' => fn ($q) => $q->orderBy('created_at', 'asc')])
            ->where('ticket_code', $normalizedTicket)
            ->first();

        $isAuthorized = (bool) $request->session()->get('authenticated_ticket_'.$normalizedTicket, false);

        return view('tickets.show', [
            'ticket' => $normalizedTicket,
            'report' => $report,
            'isAuthorized' => $isAuthorized,
        ]);
    }

    public function reply(string $ticket, Request $request, PiiMasker $piiMasker): RedirectResponse
    {
        $normalizedTicket = strtoupper(trim($ticket));
        $isAuthorized = (bool) $request->session()->get('authenticated_ticket_'.$normalizedTicket, false);

        if (! $isAuthorized) {
            return redirect()->route('ticket.show', ['ticket' => $normalizedTicket])
                ->withErrors(['auth' => 'Sesi autentikasi telah berakhir. Silakan masukkan kembali kode rahasia Anda.']);
        }

        $report = Report::where('ticket_code', $normalizedTicket)->firstOrFail();

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:5', 'max:1500'],
        ], [
            'message.required' => 'Pesan tanggapan wajib diisi.',
            'message.min' => 'Pesan tanggapan minimal 5 karakter.',
        ]);

        /** @var string $rawMessage */
        $rawMessage = $validated['message'];
        $cleanMessage = $piiMasker->mask($rawMessage);

        ReportUpdate::create([
            'report_id' => $report->id,
            'status' => $report->status,
            'message' => 'Tanggapan Pelapor: '.$cleanMessage,
            'is_public' => true,
        ]);

        return redirect()->route('ticket.show', ['ticket' => $normalizedTicket])
            ->with('success', 'Keterangan tambahan Anda berhasil dikirim dan dicatat pada riwayat tiket.');
    }
}
