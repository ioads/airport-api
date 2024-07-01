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
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('buyer_name')->nullable();
            $table->string('buyer_cpf')->nullable();
            $table->date('buyer_birthdate')->nullable();
            $table->string('buyer_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('buyer_name');
            $table->dropColumn('buyer_cpf');
            $table->dropColumn('buyer_birthdate');
            $table->dropColumn('buyer_email');
        });
    }
};
