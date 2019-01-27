<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ApiDocCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apidoc:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an api doc.';

    /**
     * @var string the deploy markdown template file path.
     */

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
        // 获取终端的各种参数
        $quarter = $this->ask('The Quarter is ?', date('Y_Qn'));
        $date = $this->ask('Input your deploy MD file name ?', date('md'));
        $tag = $this->ask("What's this version tag ?", '1.0.1');
    }
}
