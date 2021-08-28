<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIfoodAuthorizationTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifood_authorizations', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->morphs('authorizable');

            // $table->text('merchant_id')->nullable();

            $table->text('user_code')->nullable();
            $table->text('authorization_code')->nullable();
            $table->text('authorization_code_verifier')->nullable();
            $table->text('authorization_code_expires_date')->nullable();

            $table->text('verification_url')->nullable();
            $table->text('verification_url_complete')->nullable();

            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->text('token_expires_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ifood_authorizations');
    }
}
