<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
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

        return view('home', compact('demoReceipts'));
    }
}
