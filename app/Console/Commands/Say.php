<?php

namespace App\Console\Commands;

use App\Enums\DataTypeEnum;
use App\Objects\UserObject;
use Illuminate\Console\Command;

class Say extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Say {keywords?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取关注用户';

    /**
     * Base constructor.
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
        $user = UserObject::instance([
            'name' => 'abc',
            'age' => 25,
            'py' => 'abc',
            'target' => new UserObject([
                'name' => 'bbb',
                'age' => 12,
                'target' => new UserObject(["name" => 'ccc']),
            ])
        ]);
        $u = call_user_func([UserObject::class], ['name'=>'xj']);
        var_dump(json_encode($u));
//        var_dump(json_encode($user));
//        var_dump(json_encode($user->target->target->target));
//        $this->line($user->toArray());
//        var_dump(DataTypeEnum::Enums());
        return true;
    }
}
