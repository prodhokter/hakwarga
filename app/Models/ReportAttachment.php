<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportAttachment extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'report_id',
        'disk',
        'path',
        'mime',
        'size_bytes',
        'sha256',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'size_bytes' => 'integer',
    ];

    /** @return BelongsTo<Report, $this> */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
