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
        Schema::table('pengembalians', function (Blueprint $table) {
            // Add status field for tracking return request status
            $table->enum('status', ['pending', 'dikembalikan'])->default('dikembalikan')->after('id_pengajuan');
            
            // Add user who requested the return (pegawai)
            $table->foreignId('id_user')->nullable()->after('id_pengajuan')->constrained('users')->onDelete('set null');
            
            // Make id_petugas nullable (pegawai can request first)
            $table->foreignId('id_petugas')->nullable()->change();
            
            // Add verification timestamp
            $table->timestamp('verified_at')->nullable()->after('tanggal_pengembalian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengembalians', function (Blueprint $table) {
            $table->dropColumn(['status', 'id_user', 'verified_at']);
        });
    }
};
