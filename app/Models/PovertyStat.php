<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PovertyStat extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'region_id',
        'year',
        'poverty_percent',
        'poor_population',
        'source',
        'source_url',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'year' => 'integer',
        'poverty_percent' => 'decimal:2',
        'poor_population' => 'integer',
    ];

    /** @return BelongsTo<Region, $this> */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
