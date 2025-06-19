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
        Schema::table('software_users', function (Blueprint $table) {
            $table->unsignedBigInteger('team_lead_id')->nullable()->after('role');
            $table->foreign('team_lead_id')->references('id')->on('software_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('software_users', function (Blueprint $table) {
            $table->dropForeign(['team_lead_id']);
            $table->dropColumn('team_lead_id');
        });
    }
};
