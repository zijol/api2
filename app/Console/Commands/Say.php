<?php

namespace App\Console\Commands;

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
        $argv = $this->arguments();
        $keywords = $argv["keywords"] ?? "hello world!";
        $this->info($keywords);
        var_dump(yaConfig("db"));
        return true;
    }
}
