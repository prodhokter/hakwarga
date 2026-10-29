<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\AnomalyFlag;
use App\Services\AnomalyService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class MapController extends Controller
{
    public function index(AnomalyService $anomalyService): View
    {
        $anomalies = $anomalyService->getAnomalies('2026-10');

        $underCount = $anomalies->where('flag', AnomalyFlag::UnderCoverage)->count();
        $overCount = $anomalies->where('flag', AnomalyFlag::OverCoverage)->count();
        $normalCount = $anomalies->where('flag', AnomalyFlag::Normal)->count();

        return view('map.index', [
            'anomalies' => $anomalies,
            'underCount' => $underCount,
            'overCount' => $overCount,
            'normalCount' => $normalCount,
            'period' => 'Oktober 2026',
        ]);
    }

    public function choropleth(AnomalyService $anomalyService): JsonResponse
    {
        $cacheKey = 'hw:map:choropleth:2026-10';

        /** @var array<string, mixed> $data */
        $data = Cache::remember($cacheKey, 3600, function () use ($anomalyService): array {
            $geoJsonPath = public_path('geo/central_java.geojson');

            if (! file_exists($geoJsonPath)) {
                return ['type' => 'FeatureCollection', 'features' => []];
            }

            /** @var string $raw */
            $raw = file_get_contents($geoJsonPath);
            /** @var array{type: string, features: array<int, array{type: string, properties: array<string, mixed>, geometry: array<string, mixed>}>} $geoJson */
            $geoJson = json_decode($raw, true);

            $anomalies = $anomalyService->getAnomalies('2026-10')->keyBy('bps_code');

            foreach ($geoJson['features'] as &$feature) {
                $code = (string) ($feature['properties']['bps_code'] ?? '');
                $anomaly = $anomalies->get($code);

                if ($anomaly) {
                    $feature['properties']['quota_recipients'] = $anomaly->quota_recipients;
                    $feature['properties']['poor_estimate'] = (int) $anomaly->poor_estimate;
                    $feature['properties']['targeting_ratio'] = round((float) $anomaly->targeting_ratio, 3);
                    $feature['properties']['relative_ratio'] = round((float) $anomaly->relative_ratio, 2);
                    $feature['properties']['flag'] = $anomaly->flag->value;
                    $feature['properties']['flag_label'] = $anomaly->flag->label();
                    $feature['properties']['severity'] = $anomaly->severity;
                }
            }

            return $geoJson;
        });

        return response()->json($data);
    }
}
