<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AnomalyFlag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnomalyService
{
    protected float $underThreshold;

    protected float $overThreshold;

    protected float $highUnder;

    protected float $highOver;

    public function __construct()
    {
        /** @var float $underThreshold */
        $underThreshold = config('hakwarga.anomaly.under_threshold', 0.5);
        $this->underThreshold = (float) $underThreshold;

        /** @var float $overThreshold */
        $overThreshold = config('hakwarga.anomaly.over_threshold', 1.5);
        $this->overThreshold = (float) $overThreshold;

        /** @var float $highUnder */
        $highUnder = config('hakwarga.anomaly.high_under', 0.3);
        $this->highUnder = (float) $highUnder;

        /** @var float $highOver */
        $highOver = config('hakwarga.anomaly.high_over', 2.0);
        $this->highOver = (float) $highOver;
    }

    public function classifyRatio(float $relativeRatio): AnomalyFlag
    {
        if ($relativeRatio < $this->underThreshold) {
            return AnomalyFlag::UnderCoverage;
        }

        if ($relativeRatio > $this->overThreshold) {
            return AnomalyFlag::OverCoverage;
        }

        return AnomalyFlag::Normal;
    }

    public function calculateSeverity(float $relativeRatio): string
    {
        if ($relativeRatio < $this->highUnder || $relativeRatio > $this->highOver) {
            return 'high';
        }

        if ($relativeRatio < $this->underThreshold || $relativeRatio > $this->overThreshold) {
            return 'medium';
        }

        return 'none';
    }

    /**
     * @return Collection<int, \stdClass>
     */
    public function getAnomalies(?string $period = null, ?int $programId = null): Collection
    {
        $query = DB::table('v_anomaly_scores')
            ->join('regions', 'regions.id', '=', 'v_anomaly_scores.region_id')
            ->join('aid_programs', 'aid_programs.id', '=', 'v_anomaly_scores.program_id')
            ->select([
                'v_anomaly_scores.*',
                'regions.name as region_name',
                'regions.bps_code',
                'aid_programs.code as program_code',
                'aid_programs.name as program_name',
            ]);

        if ($period !== null) {
            $query->where('v_anomaly_scores.period', $period);
        }

        if ($programId !== null) {
            $query->where('v_anomaly_scores.program_id', $programId);
        }

        return $query->get()->map(function ($row) {
            $relativeRatio = (float) ($row->relative_ratio ?? 1.0);
            $row->flag = $this->classifyRatio($relativeRatio);
            $row->severity = $this->calculateSeverity($relativeRatio);

            return $row;
        });
    }
}
