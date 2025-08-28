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
        Schema::create('demande_serveur', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->enum('environnement', ['DEV', 'TEST', 'PREPROD', 'PROD']);
            $table->enum('type_serveur', ['physique', 'virtuel', 'cloud'])->default('virtuel');

            $table->string('systeme_exploitation', 100);
            $table->string('version_os', 50);
            $table->enum('architecture', ['32-bit', '64-bit'])->default('64-bit');

            $table->unsignedInteger('ram_go');       // RAM en Go
            $table->unsignedInteger('stockage_go');  // Stockage en Go
            $table->enum('type_stockage', ['HDD', 'SSD'])->default('SSD');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_serveur');
    }
};
