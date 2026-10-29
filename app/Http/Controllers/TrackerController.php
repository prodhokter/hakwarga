<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ShipmentTrackingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TrackerController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $code = $request->query('code');

        if (is_string($code) && trim($code) !== '') {
            $normalized = strtoupper(trim($code));

            return redirect()->route('tracker.show', ['receipt' => $normalized]);
        }

        $demoReceipts = [
            'HWR-PKH-2610-DEMO01',
            'HWR-BPNT-2610-DEMO02',
            'HWR-PKH-2610-DEMO03',
        ];

        return view('tracker.index', compact('demoReceipts'));
    }

    public function show(string $receipt, ShipmentTrackingService $trackingService): View
    {
        $normalized = strtoupper(trim($receipt));
        $shipment = $trackingService->findByReceipt($normalized);

        return view('tracker.show', [
            'receipt' => $normalized,
            'shipment' => $shipment,
        ]);
    }
}
