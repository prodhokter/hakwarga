<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code', 16)->unique();
            $table->char('secret_hash', 64);
            $table->string('type', 20);
            $table->string('category', 40);
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained('aid_programs')->nullOnDelete();
            $table->foreignId('target_beneficiary_id')->nullable()->constrained('beneficiaries')->nullOnDelete();
            $table->bigInteger('amount_claimed')->nullable();
            $table->text('description');
            $table->string('status', 20)->default('submitted');
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->boolean('is_simulated')->default(true);
            $table->timestamps();

            $table->index(['agency_id', 'status']);
            $table->index(['region_id', 'created_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
