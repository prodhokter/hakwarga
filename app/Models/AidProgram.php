<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AidProgram extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'code',
        'name',
        'description',
        'cash_value',
        'goods_value',
        'goods_description',
        'frequency',
        'is_active',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'cash_value' => 'integer',
        'goods_value' => 'integer',
        'is_active' => 'boolean',
    ];

    /** @return HasMany<AidAllocation, $this> */
    public function aidAllocations(): HasMany
    {
        return $this->hasMany(AidAllocation::class, 'program_id');
    }

    /** @return HasMany<Beneficiary, $this> */
    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class, 'program_id');
    }

    /** @return HasMany<Shipment, $this> */
    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'program_id');
    }
}
