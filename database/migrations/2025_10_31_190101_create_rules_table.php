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
        Schema::create('rules', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete(); // PHP Laravel Blade
            $table->string('type'); // free | paid
            $table->unsignedInteger('downloads')->default(0);
            $table->decimal('rating', 2, 1)->default(0); // e.g. 4.8
            $table->json('metadata')->nullable(); // optional extra data (tags, versions, etc.)
            $table->string('status');
            $table->timestamps();
        });
    }
};
