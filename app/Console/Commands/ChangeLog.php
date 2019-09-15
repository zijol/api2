<?php

namespace App\Console\Commands;

use App\Services\Http\HttpClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
        $ht = new HttpClient("http://127.0.0.1:5000");
        $res =$ht->get('/douyin/qr_code', ['user_id' => '60043717321']);
        var_dump($res['content']);
        // 加载changelog.md
        file_put_contents('/tmp/time.log', date('Y-m-d H:i:s') . PHP_EOL);
    }
}
