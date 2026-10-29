<?php

declare(strict_types=1);

namespace App\Enums;

enum AgencyType: string
{
    case ProvincialSocialOffice = 'provincial_social_office';
    case RegencySocialOffice = 'regency_social_office';
    case DistrictOffice = 'district_office';
    case VillageOffice = 'village_office';
    case Distributor = 'distributor';

    public function label(): string
    {
        return match ($this) {
            self::ProvincialSocialOffice => 'Dinas Sosial Provinsi',
            self::RegencySocialOffice => 'Dinas Sosial Kabupaten/Kota',
            self::DistrictOffice => 'Kantor Kecamatan',
            self::VillageOffice => 'Kantor Desa/Kelurahan',
            self::Distributor => 'Penyalur / Ekspedisi Resmi',
        };
    }
}
