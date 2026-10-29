<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AgencyType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'region_id',
        'is_simulated',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'type' => AgencyType::class,
        'is_simulated' => 'boolean',
    ];

    /** @return BelongsTo<Region, $this> */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /** @return HasMany<Shipment, $this> */
    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    /** @return HasMany<User, $this> */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
