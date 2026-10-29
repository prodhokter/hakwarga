<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EligibilityStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiary extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'public_id',
        'region_id',
        'program_id',
        'nik_hash',
        'masked_name',
        'masked_address',
        'eligibility_status',
        'is_simulated',
    ];

    /** @var list<string> */
    protected $hidden = [
        'nik_hash',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'eligibility_status' => EligibilityStatus::class,
        'is_simulated' => 'boolean',
    ];

    /** @return BelongsTo<Region, $this> */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /** @return BelongsTo<AidProgram, $this> */
    public function program(): BelongsTo
    {
        return $this->belongsTo(AidProgram::class, 'program_id');
    }

    /** @return HasMany<Shipment, $this> */
    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}
