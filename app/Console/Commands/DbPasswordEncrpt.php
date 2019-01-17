<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Helper\Encryption;

class DbPasswordEncrypt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DbPasswordEncrypt:run {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '数据库密码加密';

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
        $arguments = $this->arguments();
        $password = $arguments['password'] ?? "";
        $this->info(Encryption::encryptPassword($password, env('API_ENCRYPTION_KEY')));
    }
}
