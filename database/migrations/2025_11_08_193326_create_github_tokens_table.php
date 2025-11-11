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
        Schema::create('github_tokens', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->bigInteger('github_id')->unique();
            $table->string('github_login');
            $table->longText('access_token');
            $table->boolean('is_valid')->default(true);
            $table->timestamps();

            $table->index('user_id');
        });
    }
};
