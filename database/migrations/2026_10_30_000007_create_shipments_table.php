<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_code', 24)->unique();
            $table->foreignId('beneficiary_id')->constrained('beneficiaries')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('aid_programs')->cascadeOnDelete();
            $table->foreignId('agency_id')->constrained('agencies')->cascadeOnDelete();
            $table->char('period', 7);
            $table->bigInteger('entitled_cash')->default(0);
            $table->bigInteger('entitled_goods_value')->default(0);
            $table->string('entitled_goods_description', 160)->nullable();
            $table->string('current_status', 32);
            $table->string('distribution_point', 120)->nullable();
            $table->boolean('is_simulated')->default(true);
            $table->timestamps();

            $table->index(['agency_id', 'current_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
