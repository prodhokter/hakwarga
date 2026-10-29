<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AgencyType;
use App\Enums\EligibilityStatus;
use App\Enums\RegionLevel;
use App\Enums\ShipmentStatus;
use App\Models\Agency;
use App\Models\AidProgram;
use App\Models\Beneficiary;
use App\Models\Region;
use App\Models\Shipment;
use App\Models\ShipmentEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoScenarioSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hierarchical Pilot Regions
        $jateng = Region::firstOrCreate(
            ['bps_code' => '33'],
            [
                'name' => 'Jawa Tengah',
                'level' => RegionLevel::Province,
                'population' => 37000000,
                'is_pilot' => false,
            ]
        );

        $banyumas = Region::firstOrCreate(
            ['bps_code' => '3302'],
            [
                'name' => 'Kabupaten Banyumas',
                'level' => RegionLevel::Regency,
                'parent_id' => $jateng->id,
                'population' => 1800000,
                'is_pilot' => false,
            ]
        );

        $patikraja = Region::firstOrCreate(
            ['bps_code' => '330211'],
            [
                'name' => 'Kecamatan Patikraja',
                'level' => RegionLevel::District,
                'parent_id' => $banyumas->id,
                'population' => 60000,
                'is_pilot' => false,
            ]
        );

        $kedungwringin = Region::firstOrCreate(
            ['bps_code' => '3302112001'],
            [
                'name' => 'Desa Kedungwringin',
                'level' => RegionLevel::Village,
                'parent_id' => $patikraja->id,
                'population' => 5200,
                'is_pilot' => true,
            ]
        );

        // 2. Agencies
        $dinsos = Agency::firstOrCreate(
            ['slug' => 'dinsos-banyumas'],
            [
                'name' => 'Dinas Sosial Kabupaten Banyumas',
                'type' => AgencyType::RegencySocialOffice,
                'region_id' => $banyumas->id,
                'is_simulated' => true,
            ]
        );

        $pos = Agency::firstOrCreate(
            ['slug' => 'pos-purwokerto'],
            [
                'name' => 'PT Pos Indonesia KC Purwokerto',
                'type' => AgencyType::Distributor,
                'region_id' => $banyumas->id,
                'is_simulated' => true,
            ]
        );

        // 3. Aid Programs
        $pkh = AidProgram::firstOrCreate(
            ['code' => 'PKH'],
            [
                'name' => 'Program Keluarga Harapan',
                'description' => 'Bantuan sosial tunai bersyarat bagi keluarga rentan kemiskinan dengan komponen kesehatan, pendidikan, dan kesejahteraan.',
                'cash_value' => 750000,
                'goods_value' => 0,
                'goods_description' => null,
                'frequency' => 'quarterly',
                'is_active' => true,
            ]
        );

        $bpnt = AidProgram::firstOrCreate(
            ['code' => 'BPNT'],
            [
                'name' => 'Bantuan Pangan Non-Tunai (Sembako)',
                'description' => 'Bantuan pangan komoditas sembako bergizi untuk pemenuhan pangan pokok keluarga penerima manfaat.',
                'cash_value' => 0,
                'goods_value' => 200000,
                'goods_description' => 'Beras Premium 10 kg, Telur Ayam 1 kg',
                'frequency' => 'monthly',
                'is_active' => true,
            ]
        );

        // 4. Beneficiaries (Masked Simulation Data)
        /** @var string $pepper */
        $pepper = config('hakwarga.nik_pepper', 'simulated-pepper');

        $ben1 = Beneficiary::firstOrCreate(
            ['public_id' => '01JB00000000000000000DEMO1'],
            [
                'region_id' => $kedungwringin->id,
                'program_id' => $pkh->id,
                'nik_hash' => hash_hmac('sha256', '3302112001990001', $pepper),
                'masked_name' => 'S*** W***',
                'masked_address' => 'RT 02/RW 03',
                'eligibility_status' => EligibilityStatus::Eligible,
                'is_simulated' => true,
            ]
        );

        $ben2 = Beneficiary::firstOrCreate(
            ['public_id' => '01JB00000000000000000DEMO2'],
            [
                'region_id' => $kedungwringin->id,
                'program_id' => $bpnt->id,
                'nik_hash' => hash_hmac('sha256', '3302112001990002', $pepper),
                'masked_name' => 'A*** H***',
                'masked_address' => 'RT 01/RW 01',
                'eligibility_status' => EligibilityStatus::Eligible,
                'is_simulated' => true,
            ]
        );

        $ben3 = Beneficiary::firstOrCreate(
            ['public_id' => '01JB00000000000000000DEMO3'],
            [
                'region_id' => $kedungwringin->id,
                'program_id' => $pkh->id,
                'nik_hash' => hash_hmac('sha256', '3302112001990003', $pepper),
                'masked_name' => 'M*** T***',
                'masked_address' => 'RT 04/RW 02',
                'eligibility_status' => EligibilityStatus::Eligible,
                'is_simulated' => true,
            ]
        );

        // 5. Gold Demo Shipment 1: In Delivery (Step 4 of 5)
        $ship1 = Shipment::updateOrCreate(
            ['receipt_code' => 'HWR-PKH-2610-DEMO01'],
            [
                'beneficiary_id' => $ben1->id,
                'program_id' => $pkh->id,
                'agency_id' => $pos->id,
                'period' => '2026-10',
                'entitled_cash' => 750000,
                'entitled_goods_value' => 0,
                'entitled_goods_description' => null,
                'current_status' => ShipmentStatus::InDelivery,
                'distribution_point' => 'Balai Desa Kedungwringin',
                'is_simulated' => true,
            ]
        );

        ShipmentEvent::where('shipment_id', $ship1->id)->delete();
        ShipmentEvent::insert([
            [
                'shipment_id' => $ship1->id,
                'status' => ShipmentStatus::DataCollected->value,
                'occurred_at' => Carbon::now()->subDays(6)->setHour(9)->setMinute(0),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Pendataan DTKS wilayah Desa Kedungwringin selesai dicatat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship1->id,
                'status' => ShipmentStatus::EligibilityVerified->value,
                'occurred_at' => Carbon::now()->subDays(4)->setHour(14)->setMinute(30),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Kelayakan komponen balita & lansia terverifikasi sah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship1->id,
                'status' => ShipmentStatus::Scheduled->value,
                'occurred_at' => Carbon::now()->subDays(2)->setHour(10)->setMinute(15),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Jadwal distribusi ditetapkan ke Kantor Pos Cabang Pembantu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship1->id,
                'status' => ShipmentStatus::InDelivery->value,
                'occurred_at' => Carbon::now()->subHours(18)->setMinute(45),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Dana bansos dalam perjalanan kurir resmi menuju titik salur Balai Desa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 6. Gold Demo Shipment 2: Scheduled (Step 3 of 5)
        $ship2 = Shipment::updateOrCreate(
            ['receipt_code' => 'HWR-BPNT-2610-DEMO02'],
            [
                'beneficiary_id' => $ben2->id,
                'program_id' => $bpnt->id,
                'agency_id' => $pos->id,
                'period' => '2026-10',
                'entitled_cash' => 0,
                'entitled_goods_value' => 200000,
                'entitled_goods_description' => 'Beras Premium 10 kg, Telur Ayam 1 kg',
                'current_status' => ShipmentStatus::Scheduled,
                'distribution_point' => 'E-Warong Amanah Kedungwringin',
                'is_simulated' => true,
            ]
        );

        ShipmentEvent::where('shipment_id', $ship2->id)->delete();
        ShipmentEvent::insert([
            [
                'shipment_id' => $ship2->id,
                'status' => ShipmentStatus::DataCollected->value,
                'occurred_at' => Carbon::now()->subDays(5)->setHour(10)->setMinute(0),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Pendataan kuota sembako alokasi Oktober 2026.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship2->id,
                'status' => ShipmentStatus::EligibilityVerified->value,
                'occurred_at' => Carbon::now()->subDays(3)->setHour(11)->setMinute(30),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Verifikasi desil 1 selesai tanpa sanggahan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship2->id,
                'status' => ShipmentStatus::Scheduled->value,
                'occurred_at' => Carbon::now()->subDays(1)->setHour(15)->setMinute(0),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Pengemasan komoditas sembako dan jadwal ambil di E-Warong terdekat disiapkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 7. Gold Demo Shipment 3: Received at Point (Step 5 of 5)
        $ship3 = Shipment::updateOrCreate(
            ['receipt_code' => 'HWR-PKH-2610-DEMO03'],
            [
                'beneficiary_id' => $ben3->id,
                'program_id' => $pkh->id,
                'agency_id' => $dinsos->id,
                'period' => '2026-10',
                'entitled_cash' => 600000,
                'entitled_goods_value' => 0,
                'entitled_goods_description' => null,
                'current_status' => ShipmentStatus::ReceivedAtPoint,
                'distribution_point' => 'Balai Desa Kedungwringin',
                'is_simulated' => true,
            ]
        );

        ShipmentEvent::where('shipment_id', $ship3->id)->delete();
        ShipmentEvent::insert([
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::DataCollected->value,
                'occurred_at' => Carbon::now()->subDays(7)->setHour(8)->setMinute(30),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Pendataan awal penerima PKH lansia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::EligibilityVerified->value,
                'occurred_at' => Carbon::now()->subDays(5)->setHour(13)->setMinute(0),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Verifikasi NIK dan status kependudukan valid.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::Scheduled->value,
                'occurred_at' => Carbon::now()->subDays(4)->setHour(9)->setMinute(0),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Jadwal serah terima di Balai Desa Kedungwringin disahkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::InDelivery->value,
                'occurred_at' => Carbon::now()->subDays(2)->setHour(8)->setMinute(0),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Dana disalurkan melalui petugas juru bayar kantor pos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::ReceivedAtPoint->value,
                'occurred_at' => Carbon::now()->subDay()->setHour(11)->setMinute(20),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Bantuan telah diterima utuh di Balai Desa Kedungwringin tanpa potongan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
