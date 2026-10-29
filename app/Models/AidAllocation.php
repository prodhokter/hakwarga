<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AidAllocation extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'region_id',
        'program_id',
        'period',
        'quota_recipients',
        'actual_recipients',
        'budget',
        'is_simulated',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'quota_recipients' => 'integer',
        'actual_recipients' => 'integer',
        'budget' => 'integer',
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
}
