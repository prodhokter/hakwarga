<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RegionLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'bps_code',
        'name',
        'level',
        'parent_id',
        'population',
        'is_pilot',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'level' => RegionLevel::class,
        'population' => 'integer',
        'is_pilot' => 'boolean',
    ];

    /** @return BelongsTo<Region, $this> */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /** @return HasMany<Region, $this> */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /** @return HasMany<PovertyStat, $this> */
    public function povertyStats(): HasMany
    {
        return $this->hasMany(PovertyStat::class);
    }

    /** @return HasMany<AidAllocation, $this> */
    public function aidAllocations(): HasMany
    {
        return $this->hasMany(AidAllocation::class);
    }

    /** @return HasMany<Agency, $this> */
    public function agencies(): HasMany
    {
        return $this->hasMany(Agency::class);
    }

    /** @return HasMany<Beneficiary, $this> */
    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }
}
