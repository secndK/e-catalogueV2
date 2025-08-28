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
        Schema::create('catalogues', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('app_name');
            $table->text('desc_app')->nullable();
            $table->string('url_app')->nullable();
            $table->string('url_doc')->nullable();
            $table->string('url_git')->nullable();
            $table->string('env_dev')->nullable();
            $table->string('url_dev')->nullable();
            $table->string('adr_serv_dev')->nullable();
            $table->string('nom_dns')->nullable();
            $table->string('sys_exp_dev')->nullable();
            $table->string('vers_sys_dev')->nullable();
            $table->string('dist_sys_dev')->nullable();
            $table->string('adr_serv_bd_dev')->nullable();
            $table->string('sys_exp_bd_dev')->nullable();
            $table->string('nom_bd_dev')->nullable();
            $table->string('port_bd_dev')->nullable();
            $table->string('user_bd_dev')->nullable();
            $table->string('lang_deve_dev')->nullable();
            $table->string('vers_lang_dev')->nullable();
            $table->string('fram_dev')->nullable();
            $table->string('vers_fram_dev')->nullable();
            $table->json('critical_dev')->nullable();
            $table->string('statut_dev')->nullable();
            $table->string('env_prod')->nullable();
            $table->string('url_prod')->nullable();
            $table->string('adr_serv_prod')->nullable();
            $table->string('sys_exp_prod')->nullable();
            $table->string('vers_sys_prod')->nullable();
            $table->string('dist_sys_prod')->nullable();
            $table->string('adr_serv_bd_prod')->nullable();
            $table->string('sys_exp_bd_prod')->nullable();
            $table->string('nom_bd_prod')->nullable();
            $table->string('port_bd_prod')->nullable();
            $table->string('user_bd_prod')->nullable();
            $table->string('lang_deve_prod')->nullable();
            $table->string('vers_lang_prod')->nullable();
            $table->string('fram_prod')->nullable();
            $table->string('vers_fram_prod')->nullable();
            $table->json('critical_prod')->nullable();
            $table->string('statut_prod')->nullable();
            $table->string('env_test')->nullable();
            $table->string('url_test')->nullable();
            $table->string('adr_serv_test')->nullable();
            $table->string('sys_exp_test')->nullable();
            $table->string('vers_sys_test')->nullable();
            $table->string('dist_sys_test')->nullable();
            $table->string('adr_serv_bd_test')->nullable();
            $table->string('sys_exp_bd_test')->nullable();
            $table->string('nom_bd_test')->nullable();
            $table->string('port_bd_test')->nullable();
            $table->string('user_bd_test')->nullable();
            $table->string('lang_deve_test')->nullable();
            $table->string('vers_lang_test')->nullable();
            $table->string('fram_test')->nullable();
            $table->string('vers_fram_test')->nullable();
            $table->json('critical_test')->nullable();
            $table->string('statut_test')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogues');
    }
};
