<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ReleaseDeploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release deploy build.';

    /**
     * @var string the deploy markdown template file path.
     */
    protected $deployMarkdown = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->deployMarkdown = base_path('release') . '/deploy.md';
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
        $developmentBranch = $this->ask("What's the development branch ?", date('md'));
        $dependency = $this->ask('Input your dependency as a string.', "无");
        $rollbackTag = $this->ask("What's the rollback tag ?", "1.0.0");

        // 目标文件
        $releaseFile = base_path('release') . '/' . $quarter . '/' . $date . '.md';
        if (!File::exists($releaseFile)) {
            $tplString = File::get($this->deployMarkdown);
            $tplString = str_replace('{{ tag }}', $tag, $tplString);
            $tplString = str_replace('{{ development_branch }}', $developmentBranch, $tplString);
            $tplString = str_replace('{{ dependency }}', $dependency, $tplString);
            $tplString = str_replace('{{ rollback_tag }}', $rollbackTag, $tplString);
            File::put($releaseFile, $tplString);

            $this->info("Release file $releaseFile created ok.");
        } else {
            $this->info("Release file $releaseFile already exist.");
        }
    }
}
