<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing 'disetujui' status to 'dipinjam'
        DB::table('pengajuans')
            ->where('status', 'disetujui')
            ->update(['status' => 'dipinjam']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed - status 'disetujui' is no longer used
    }
};
