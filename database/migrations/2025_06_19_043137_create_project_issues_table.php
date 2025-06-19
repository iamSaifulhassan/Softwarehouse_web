<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['new', 'assigned', 'in_progress', 'completed', 'testing', 'approved', 'rejected'])->default('new');
            $table->foreignId('created_by')->constrained('software_users');
            $table->foreignId('assigned_to')->nullable()->constrained('software_users');
            $table->foreignId('assigned_by')->nullable()->constrained('software_users');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_issues');
    }
};
