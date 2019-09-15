<?php

namespace App\Console\Commands;

use App\Models\Dy\RawUser;
use App\Models\Dy\User;
use App\Models\Dy\UserSta;
use App\Models\Dy\VUser;
use Illuminate\Console\Command;

class DyUserSta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dy:UserSta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抖音用户统计';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rawCount = RawUser::query()->count();
        $userCount = User::query()->count();
        $vCount = VUser::query()->count();

        $us = new UserSta([
            'raw_count' => $rawCount,
            'v_count' => $vCount,
            'user_count' => $userCount
        ]);

        $us->save();
        return true;
    }
}
