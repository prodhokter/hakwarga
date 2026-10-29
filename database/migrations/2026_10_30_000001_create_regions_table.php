<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('bps_code', 10)->unique();
            $table->string('name', 120);
            $table->smallInteger('level')->index();
            $table->foreignId('parent_id')->nullable()->constrained('regions')->nullOnDelete();
            $table->integer('population')->nullable();
            $table->boolean('is_pilot')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
