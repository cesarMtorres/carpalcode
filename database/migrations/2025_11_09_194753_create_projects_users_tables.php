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
        Schema::create('project_user', function (Blueprint $table): void {
            $table->foreignId('project_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();

            $table->primary(['project_id', 'user_id']); // evita duplicados
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('projects_users_tables');
    }
};
