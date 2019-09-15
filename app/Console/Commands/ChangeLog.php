<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ChangeLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChangeLog:Update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update change log view';


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
        // 加载changelog.md
        file_put_contents('/tmp/time.log', date('Y-m-d H:i:s') . PHP_EOL);
    }
}
