<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aid_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('aid_programs')->cascadeOnDelete();
            $table->char('period', 7);
            $table->integer('quota_recipients');
            $table->integer('actual_recipients')->nullable();
            $table->bigInteger('budget')->nullable();
            $table->boolean('is_simulated')->default(true);
            $table->timestamps();

            $table->unique(['region_id', 'program_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aid_allocations');
    }
};
