<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ShipmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'receipt_code',
        'beneficiary_id',
        'program_id',
        'agency_id',
        'period',
        'entitled_cash',
        'entitled_goods_value',
        'entitled_goods_description',
        'current_status',
        'distribution_point',
        'is_simulated',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'current_status' => ShipmentStatus::class,
        'entitled_cash' => 'integer',
        'entitled_goods_value' => 'integer',
        'is_simulated' => 'boolean',
    ];

    /** @return BelongsTo<Beneficiary, $this> */
    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    /** @return BelongsTo<AidProgram, $this> */
    public function program(): BelongsTo
    {
        return $this->belongsTo(AidProgram::class, 'program_id');
    }

    /** @return BelongsTo<Agency, $this> */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    /** @return HasMany<ShipmentEvent, $this> */
    public function events(): HasMany
    {
        return $this->hasMany(ShipmentEvent::class)->orderBy('occurred_at', 'asc');
    }
}
