<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('codes', function (Blueprint $table) {
            $table->dropColumn('started_at');
            $table->dropColumn('expired_at');
            $table->addColumn('boolean', 'status')->default(0)->after('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codes', function (Blueprint $table) {
            $table->dateTime('started_at')->nullable();
            $table->dateTime('expired_at')->nullable();
        });
    }
};
