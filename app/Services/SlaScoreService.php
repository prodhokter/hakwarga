<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Agency;
use App\Models\Report;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class SlaScoreService
{
    protected int $responseHours;

    protected int $resolveDays;

    protected int $minDueReports;

    protected float $responseWeight;

    protected float $resolveWeight;

    public function __construct()
    {
        /** @var int $responseHours */
        $responseHours = config('hakwarga.sla.response_hours', 72);
        $this->responseHours = (int) $responseHours;

        /** @var int $resolveDays */
        $resolveDays = config('hakwarga.sla.resolve_days', 14);
        $this->resolveDays = (int) $resolveDays;

        /** @var int $minDueReports */
        $minDueReports = config('hakwarga.sla.min_due_reports', 5);
        $this->minDueReports = (int) $minDueReports;

        /** @var array<string, float> $weights */
        $weights = config('hakwarga.sla.weights', ['response' => 0.5, 'resolve' => 0.5]);
        $this->responseWeight = (float) ($weights['response'] ?? 0.5);
        $this->resolveWeight = (float) ($weights['resolve'] ?? 0.5);
    }

    public function isResponseOk(CarbonInterface $createdAt, ?CarbonInterface $firstResponseAt): bool
    {
        if ($firstResponseAt === null) {
            return false;
        }

        $diffHours = $createdAt->diffInHours($firstResponseAt, false);

        return $diffHours >= 0 && $diffHours <= $this->responseHours;
    }

    public function isResolveOk(CarbonInterface $createdAt, ?CarbonInterface $resolvedAt): bool
    {
        if ($resolvedAt === null) {
            return false;
        }

        $diffDays = $createdAt->diffInDays($resolvedAt, false);

        return $diffDays >= 0 && $diffDays <= $this->resolveDays;
    }

    public function calculateCompositeScore(float $responseRate, float $resolveRate): float
    {
        $score = ($this->responseWeight * $responseRate) + ($this->resolveWeight * $resolveRate);

        return round($score, 1);
    }

    public function calculateGrade(float $score): string
    {
        return match (true) {
            $score >= 85.0 => 'A',
            $score >= 70.0 => 'B',
            $score >= 55.0 => 'C',
            default => 'D',
        };
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function getAgencyScorecard(): Collection
    {
        $agencies = Agency::with('region')->get();

        return $agencies->map(function (Agency $agency): array {
            return $this->getAgencyDetails($agency);
        })->sortByDesc('final_score')->values();
    }

    /**
     * @return array<string, mixed>
     */
    public function getAgencyDetails(Agency $agency): array
    {
        $reports = Report::where('agency_id', $agency->id)->get();
        $totalReports = $reports->count();

        $dueResponseCount = 0;
        $responseOkCount = 0;
        $dueResolveCount = 0;
        $resolveOkCount = 0;

        $now = now();

        foreach ($reports as $report) {
            // Check response SLA eligibility
            $isResponseDue = $report->first_response_at !== null || $now->diffInHours($report->created_at) > $this->responseHours;
            if ($isResponseDue) {
                $dueResponseCount++;
                if ($this->isResponseOk($report->created_at, $report->first_response_at)) {
                    $responseOkCount++;
                }
            }

            // Check resolve SLA eligibility
            $isResolveDue = $report->resolved_at !== null || $now->diffInDays($report->created_at) > $this->resolveDays;
            if ($isResolveDue) {
                $dueResolveCount++;
                if ($this->isResolveOk($report->created_at, $report->resolved_at)) {
                    $resolveOkCount++;
                }
            }
        }

        $responseRate = $dueResponseCount > 0 ? round(($responseOkCount / $dueResponseCount) * 100, 1) : 0.0;
        $resolveRate = $dueResolveCount > 0 ? round(($resolveOkCount / $dueResolveCount) * 100, 1) : 0.0;
        $finalScore = $this->calculateCompositeScore($responseRate, $resolveRate);
        $grade = $this->calculateGrade($finalScore);

        return [
            'agency_id' => $agency->id,
            'agency_name' => $agency->name,
            'agency_slug' => $agency->slug,
            'agency_type' => $agency->type->label(),
            'region_name' => $agency->region->name,
            'total_reports' => $totalReports,
            'due_response_count' => $dueResponseCount,
            'response_ok_count' => $responseOkCount,
            'response_rate' => $responseRate,
            'due_resolve_count' => $dueResolveCount,
            'resolve_ok_count' => $resolveOkCount,
            'resolve_rate' => $resolveRate,
            'final_score' => $finalScore,
            'grade' => $grade,
            'is_ranked' => $dueResponseCount >= $this->minDueReports,
        ];
    }
}
