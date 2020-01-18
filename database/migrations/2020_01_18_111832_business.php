<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Business extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        Schema::connection($connection)->create(
            'member_users',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('admin_id', 32);
                $table->string('no', 32)->default('');
                $table->string('name', 32)->default('');
                $table->string('phone', 32)->default('');
                $table->tinyInteger('level')->default(0);
                $table->integer('balance')->default(0);
                $table->integer('points')->default(0);
                $table->timestampsTz();
                $table->softDeletesTz();
            });

        Schema::connection($connection)->create(
            'member_coupon_template',
            function (Blueprint $table) {
                $table->increments('id');
                $table->tinyInteger('type')->default(0)->comment("0.现金券 1.折扣券 2.满减券");
                $table->string('name', 32)->default('')->comment('券模板名称');
                $table->integer('amount')->default(0)->comment('现金券金额（分）');
                $table->tinyInteger('discount')->default(0)->comment('折扣券折扣（百分比）');
                $table->integer('attain_amount')->default(0)->comment('满减券（满X元减Y元的X）');
                $table->integer('discount_amount')->default(0)->comment('满减券（满X元减Y元的Y）');
                $table->integer('expire')->default(0)->comment('优惠券的有效期时长（秒）');
                $table->timestampsTz();
                $table->softDeletesTz();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        Schema::connection($connection)->dropIfExists('member_users');
        Schema::connection($connection)->dropIfExists('member_coupon_template');
    }
}
