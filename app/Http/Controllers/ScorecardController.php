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

    public function data(SlaScoreService $slaService, AnomalyService $anomalyService): View
    {
        $slaPreview = $slaService->getAgencyScorecard()->take(5);
        $anomaliPreview = $anomalyService->getAnomalies('2026-10')->take(5);

        return view('pages.data', compact('slaPreview', 'anomaliPreview'));
    }

    protected function sanitizeCsv(mixed $value): string
    {
        $str = (string) $value;
        if ($str !== '' && in_array($str[0], ['=', '+', '-', '@'], true)) {
            return "'".$str;
        }

        return $str;
    }

    public function export(
        string $dataset,
        SlaScoreService $slaService,
        AnomalyService $anomalyService
    ): StreamedResponse|Response {
        if ($dataset === 'sla') {
            $scorecard = $slaService->getAgencyScorecard();

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="hakwarga_scorecard_sla_'.date('Ymd').'.csv"',
            ];

            return response()->stream(function () use ($scorecard) {
                $handle = fopen('php://output', 'w');
                if ($handle === false) {
                    return;
                }
                // UTF-8 BOM for Microsoft Excel compatibility
                fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($handle, ['Instansi', 'Wilayah', 'Tipe', 'Total Aduan', 'Aduan Jatuh Tempo', 'Respon Tepat Waktu (%)', 'Penyelesaian Tepat Waktu (%)', 'Skor Akhir', 'Peringkat']);

                foreach ($scorecard as $row) {
                    fputcsv($handle, [
                        $this->sanitizeCsv($row['agency_name']),
                        $this->sanitizeCsv($row['region_name']),
                        $this->sanitizeCsv($row['agency_type']),
                        $this->sanitizeCsv($row['total_reports']),
                        $this->sanitizeCsv($row['due_response_count']),
                        $this->sanitizeCsv($row['response_rate'].'%'),
                        $this->sanitizeCsv($row['resolve_rate'].'%'),
                        $this->sanitizeCsv($row['final_score']),
                        $this->sanitizeCsv($row['grade']),
                    ]);
                }
                fclose($handle);
            }, 200, $headers);
        }

        if ($dataset === 'anomali') {
            $anomalies = $anomalyService->getAnomalies('2026-10');

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="hakwarga_anomali_bansos_'.date('Ymd').'.csv"',
            ];

            return response()->stream(function () use ($anomalies) {
                $handle = fopen('php://output', 'w');
                if ($handle === false) {
                    return;
                }
                // UTF-8 BOM for Microsoft Excel compatibility
                fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($handle, ['Kode BPS', 'Wilayah', 'Program', 'Periode', 'Kuota Penerima', 'Estimasi Miskin', 'Rasio Sasaran', 'Median Rasio', 'Rasio Relatif', 'Indikator']);

                foreach ($anomalies as $row) {
                    fputcsv($handle, [
                        $this->sanitizeCsv($row->bps_code),
                        $this->sanitizeCsv($row->region_name),
                        $this->sanitizeCsv($row->program_code),
                        $this->sanitizeCsv($row->period),
                        $this->sanitizeCsv($row->quota_recipients),
                        $this->sanitizeCsv((int) $row->poor_estimate),
                        $this->sanitizeCsv(round((float) $row->targeting_ratio, 3)),
                        $this->sanitizeCsv(round((float) $row->median_ratio, 3)),
                        $this->sanitizeCsv(round((float) $row->relative_ratio, 2).'x'),
                        $this->sanitizeCsv($row->flag->label()),
                    ]);
                }
                fclose($handle);
            }, 200, $headers);
        }

        abort(404);
    }
}
