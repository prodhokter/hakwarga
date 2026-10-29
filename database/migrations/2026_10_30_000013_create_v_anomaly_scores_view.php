<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_anomaly_scores');

        DB::statement('
            CREATE VIEW v_anomaly_scores AS
            WITH latest_poverty AS (
              SELECT DISTINCT ON (region_id)
                     region_id, poverty_percent, poor_population, year
              FROM poverty_stats
              ORDER BY region_id, year DESC
            ),
            base AS (
              SELECT a.region_id, a.program_id, a.period, r.level, r.parent_id,
                     a.quota_recipients,
                     COALESCE(lp.poor_population,
                              ROUND(r.population * lp.poverty_percent / 100.0))::numeric AS poor_estimate
              FROM aid_allocations a
              JOIN regions r         ON r.id = a.region_id
              JOIN latest_poverty lp ON lp.region_id = a.region_id
              WHERE r.population > 0
            ),
            ratios AS (
              SELECT *, quota_recipients::numeric / NULLIF(poor_estimate, 0) AS targeting_ratio
              FROM base
            ),
            medians AS (
              SELECT program_id, period, level,
                     percentile_cont(0.5) WITHIN GROUP (ORDER BY targeting_ratio) AS median_ratio
              FROM ratios
              GROUP BY program_id, period, level
            )
            SELECT r.region_id, r.program_id, r.period, r.level, r.parent_id,
                   r.quota_recipients, r.poor_estimate, r.targeting_ratio, m.median_ratio,
                   r.targeting_ratio / NULLIF(m.median_ratio, 0) AS relative_ratio
            FROM ratios r
            JOIN medians m USING (program_id, period, level)
        ');
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_anomaly_scores');
    }
};
