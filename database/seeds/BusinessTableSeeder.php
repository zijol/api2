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
        factory(\App\Models\Admin\MemberUsers::class)->times(99)->create();
        factory(\App\Models\Admin\MemberCouponTemplate::class)->times(99)->create();
    }
}
