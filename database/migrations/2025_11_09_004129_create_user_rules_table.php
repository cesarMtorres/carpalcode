<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('user_rules', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('rule_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 8, 2)->nullable();
            $table->timestamp('purchased_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'rule_id']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('user_rules');
    }
};
