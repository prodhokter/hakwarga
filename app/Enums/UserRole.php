<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Moderator = 'moderator';
    case AgencyOfficer = 'agency_officer';
    case Citizen = 'citizen';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Administrator Utama',
            self::Moderator => 'Moderator Publik',
            self::AgencyOfficer => 'Petugas Instansi',
            self::Citizen => 'Warga Terdaftar',
        };
    }
}
