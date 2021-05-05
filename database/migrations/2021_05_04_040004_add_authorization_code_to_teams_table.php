<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorizationCodeToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->text('ifood_merchant_id')
                    ->nullable();

            $table->text('ifood_authorization_code')
                    ->after('ifood_merchant_id')
                    ->nullable();

            $table->text('ifood_authorization_code_verifier')
                    ->after('ifood_authorization_code')
                    ->nullable();

            $table->text('ifood_access_token')
                    ->after('ifood_authorization_code_verifier')
                    ->nullable();

            $table->text('ifood_refresh_token')
                    ->after('ifood_access_token')
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn(
                'ifood_merchant_id',
                'ifood_authorization_code',
                'ifood_authorization_code_verifier',
                'ifood_access_token',
                'ifood_refresh_token'
            );
        });
    }
}
