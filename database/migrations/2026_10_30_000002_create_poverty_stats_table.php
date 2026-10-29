<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poverty_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->smallInteger('year');
            $table->decimal('poverty_percent', 5, 2);
            $table->integer('poor_population')->nullable();
            $table->string('source', 160);
            $table->string('source_url', 255)->nullable();
            $table->timestamps();

            $table->unique(['region_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poverty_stats');
    }
};
