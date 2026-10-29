<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->char('public_id', 26)->unique();
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('aid_programs')->cascadeOnDelete();
            $table->char('nik_hash', 64);
            $table->string('masked_name', 60);
            $table->string('masked_address', 120)->nullable();
            $table->string('eligibility_status', 20)->default('eligible');
            $table->boolean('is_simulated')->default(true);
            $table->timestamps();

            $table->unique(['program_id', 'nik_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
