<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Report;
use App\Services\AnomalyService;
use App\Services\SlaScoreService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ScorecardController extends Controller
{
    public function index(SlaScoreService $slaService): View
    {
        $scorecard = $slaService->getAgencyScorecard();

        return view('scorecard.index', compact('scorecard'));
    }

    public function show(string $slug, SlaScoreService $slaService): View
    {
        $agency = Agency::with('region')->where('slug', $slug)->firstOrFail();
        $details = $slaService->getAgencyDetails($agency);

        $reports = Report::with('region')
            ->where('agency_id', $agency->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('scorecard.show', compact('agency', 'details', 'reports'));
    }

    public function data(): View
    {
        return view('pages.data');
    }

    public function export(
        string $dataset,
        SlaScoreService $slaService,
        AnomalyService $anomalyService
    ): StreamedResponse|Response {
        if ($dataset === 'sla') {
            $scorecard = $slaService->getAgencyScorecard();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="hakwarga_scorecard_sla_'.date('Ymd').'.csv"',
            ];

            return response()->stream(function () use ($scorecard) {
                $handle = fopen('php://output', 'w');
                if ($handle === false) {
                    return;
                }
                fputcsv($handle, ['Instansi', 'Wilayah', 'Tipe', 'Total Aduan', 'Aduan Jatuh Tempo', 'Respon Tepat Waktu (%)', 'Penyelesaian Tepat Waktu (%)', 'Skor Akhir', 'Peringkat']);

                foreach ($scorecard as $row) {
                    fputcsv($handle, [
                        $row['agency_name'],
                        $row['region_name'],
                        $row['agency_type'],
                        $row['total_reports'],
                        $row['due_response_count'],
                        $row['response_rate'].'%',
                        $row['resolve_rate'].'%',
                        $row['final_score'],
                        $row['grade'],
                    ]);
                }
                fclose($handle);
            }, 200, $headers);
        }

        if ($dataset === 'anomali') {
            $anomalies = $anomalyService->getAnomalies('2026-10');

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="hakwarga_anomali_bansos_'.date('Ymd').'.csv"',
            ];

            return response()->stream(function () use ($anomalies) {
                $handle = fopen('php://output', 'w');
                if ($handle === false) {
                    return;
                }
                fputcsv($handle, ['Kode BPS', 'Wilayah', 'Program', 'Periode', 'Kuota Penerima', 'Estimasi Miskin', 'Rasio Sasaran', 'Median Rasio', 'Rasio Relatif', 'Indikator']);

                foreach ($anomalies as $row) {
                    fputcsv($handle, [
                        $row->bps_code,
                        $row->region_name,
                        $row->program_code,
                        $row->period,
                        $row->quota_recipients,
                        (int) $row->poor_estimate,
                        round((float) $row->targeting_ratio, 3),
                        round((float) $row->median_ratio, 3),
                        round((float) $row->relative_ratio, 2).'x',
                        $row->flag->label(),
                    ]);
                }
                fclose($handle);
            }, 200, $headers);
        }

        abort(404);
    }
}
