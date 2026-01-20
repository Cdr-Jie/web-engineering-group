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
        Schema::table('events', function (Blueprint $table) {
            // Add approval status column
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('visibility');
            
            // Add approval tracking columns
            $table->foreignId('approved_by')->nullable()->constrained('admins')->nullOnDelete()->after('approval_status');
            $table->timestamp('approval_date')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approval_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeignIdFor('Admin::class', 'approved_by');
            $table->dropColumn(['approval_status', 'approved_by', 'approval_date', 'rejection_reason']);
        });
    }
};
