<?php

declare(strict_types=1);

namespace App\Enums;

enum ReportStatus: string
{
    case Submitted = 'submitted';
    case Verified = 'verified';
    case Forwarded = 'forwarded';
    case InProgress = 'in_progress';
    case Resolved = 'resolved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Submitted => 'Terkirim',
            self::Verified => 'Terverifikasi',
            self::Forwarded => 'Diteruskan ke Instansi',
            self::InProgress => 'Dalam Penanganan',
            self::Resolved => 'Selesai Ditindaklanjuti',
            self::Rejected => 'Ditolak / Tidak Cukup Bukti',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Submitted => 'bg-slate-100 text-slate-700 border-slate-300',
            self::Verified => 'bg-blue-50 text-blue-700 border-blue-200',
            self::Forwarded => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            self::InProgress => 'bg-amber-50 text-amber-800 border-amber-200',
            self::Resolved => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            self::Rejected => 'bg-rose-50 text-rose-800 border-rose-200',
        };
    }
}
