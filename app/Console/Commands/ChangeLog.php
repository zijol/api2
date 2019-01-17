<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use GrahamCampbell\Markdown\Facades\Markdown;

class ChangeLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-log:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update change log view';

    protected $viewPath = '';
    protected $logPath = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->viewPath = base_path('resources') . '/views/changelog.blade.php';
        $this->logPath = base_path() . '/ChangeLog.md';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 加载changelog.md
        $logString = File::get($this->logPath);
        $logArray = explode('###', $logString);
        $newViewString = "@markdown" . PHP_EOL . $logArray[0] . "###" . $logArray[1] . "@endmarkdown" . PHP_EOL;

        File::put($this->viewPath, $newViewString);
        $this->info('Change log view file updated.');
    }
}
