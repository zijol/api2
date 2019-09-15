<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDyUserStaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dy_user_sta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id')->unique()->comment('用户统计ID');
            $table->integer('raw_count')->comment('完整信息')->nullable();
            $table->integer('user_count')->comment('用户')->nullable();
            $table->string('v_count')->comment('V用户')->nullable();
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
        Schema::dropIfExists('dy_user_sta');
    }
}
