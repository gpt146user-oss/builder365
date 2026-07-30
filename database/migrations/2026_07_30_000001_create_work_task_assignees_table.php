<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_task_assignees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_task_id')->constrained('work_tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['work_task_id', 'user_id']);
        });

        // Migrate existing single assignees to pivot table
        DB::statement("
            INSERT IGNORE INTO work_task_assignees (work_task_id, user_id, created_at, updated_at)
            SELECT id, assigned_to_user_id, NOW(), NOW()
            FROM work_tasks
            WHERE assigned_to_user_id IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_task_assignees');
    }
};
