<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->integer( 'activation_code_id' );
            $table->string( 'username', 10 )->unique();
            $table->string( 'firstname', 45 );
            $table->string( 'lastname', 45 );
            $table->tinyText( 'profile_image' )->nullable();
            $table->string( 'mobile', 12 )->nullable();
            $table->tinyInteger( 'gender' )->default( 0 )->comment( "1: MALE\n2: FEMALE\n4: pooshekar" );
            $table->boolean( 'is_admin' )->default( 0 );
            $table->tinyInteger( 'status' )->default( 1 )->comment( "1: ENABLED\n2: DISABLED\n3: SUSPENDED" );
            $table->boolean( 'is_logged_in' )->default( 0 );
            $table->timestamp( "last_login_at" )->nullable();
            $table->timestamp( "expired_at" )->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp( 'recovered_password_at' )->nullable();
            $table->string( 'cookie', 70 )->nullable();
            $table->string( 'password', 100 );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
