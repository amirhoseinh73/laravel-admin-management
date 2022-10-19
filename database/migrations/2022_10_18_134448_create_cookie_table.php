<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCookieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cookie', function (Blueprint $table) {
            $table->id();
            $table->string( 'cookie', 70 );
            $table->string( 'ip_address', 15 )->nullable();
            $table->string( 'user_agent', 100 )->nullable();
            $table->timestamp( 'expired_at' );
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cookie');
    }
}
