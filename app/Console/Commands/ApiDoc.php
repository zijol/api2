<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ApiDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an api doc.';

    protected $configJsonFile = '';
    protected $docTemplateMd = '';
    protected $docPath = '';
    protected $docFileName = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->configJsonFile = config('doc_config_json');
        $this->docTemplateMd = config('template_md');
        $this->docPath = config('doc_path');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $config = File::get($this->configJsonFile);
        $config = json_decode($config, true);

        // 获取终端的各种参数
        $module = $this->ask('The module is ?[' . implode(',', array_keys($config)) . ']');
        $index = $this->ask('Input your file index ?');
        $name = $this->ask("What's the interface name ?");

        $config[$module]['docs'][$index] = $name;
        File::put($this->configJsonFile, json_encode($config, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->docFileName = $this->docPath . '/' . $module . '/' . $index . '.md';
        if (!File::exists($this->docFileName)) {
            File::put($this->docFileName, File::get($this->docTemplateMd));
        }
    }
}
