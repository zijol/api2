<?php

use Illuminate\Database\Seeder;

class BusinessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Admin\MemberUserModel::class)->times(99)->create();
        factory(\App\Models\Admin\CouponTemplateModel::class)->times(99)->create();
        factory(\App\Models\Admin\ArModel::class)->times(10)->create();
    }
}
