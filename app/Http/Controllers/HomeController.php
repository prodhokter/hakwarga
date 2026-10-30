<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Shipment;
use App\Services\AnomalyService;
use App\Services\SlaScoreService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(AnomalyService $anomalyService, SlaScoreService $slaService): View
    {
        $demoReceipts = [
            [
                'code' => 'HWR-PKH-2610-DEMO01',
                'program' => 'PKH',
                'status' => 'Dalam Pengiriman (Tahap 4)',
                'entitlement' => 'Rp750.000',
            ],
            [
                'code' => 'HWR-BPNT-2610-DEMO02',
                'program' => 'BPNT',
                'status' => 'Penjadwalan (Tahap 3)',
                'entitlement' => 'Sembako Rp200.000',
            ],
            [
                'code' => 'HWR-PKH-2610-DEMO03',
                'program' => 'PKH',
                'status' => 'Diterima di Titik Salur (Tahap 5)',
                'entitlement' => 'Rp600.000',
            ],
        ];

        $anomalies = $anomalyService->getAnomalies('2026-10');
        $topAnomalies = $anomalies->take(4);
        $topAgencies = $slaService->getAgencyScorecard()->take(3);

        $stats = [
            'total_regions' => Region::where('level', 2)->count(),
            'total_shipments' => Shipment::count(),
            'under_count' => $anomalies->where('flag.value', 'under_coverage')->count(),
            'over_count' => $anomalies->where('flag.value', 'over_coverage')->count(),
        ];

        return view('home', compact('demoReceipts', 'topAnomalies', 'topAgencies', 'stats'));
    }
}
