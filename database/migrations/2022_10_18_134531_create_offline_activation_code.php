<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineActivationCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_activation_code', function (Blueprint $table) {
            $table->id();
            $table->string( 'grade', 10 )->nullable();
            $table->string( 'index_code', 6 );
            $table->string( 'windows_code', 25 );
            $table->string( 'user_code', 25 )->nullable();
            $table->string( 'generated_code', 10 )->nullable();
            $table->tinyInteger( 'limit_usage' )->default( 3 );
            $table->string( 'mobile', 11 )->nullable();
            $table->boolean( 'is_for_shopping_site' )->default( false )->comment( "اگر این کد برای فروش در سایت باشد" );
            $table->boolean( 'is_sold' )->nullable()->comment( "اگر از طریق سایت این کد فروخته شده باشد" );
            $table->integer( "order_id" )->nullable();
            $table->integer( "product_id" )->nullable();
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
        Schema::dropIfExists('offline_activation_code');
    }
}
