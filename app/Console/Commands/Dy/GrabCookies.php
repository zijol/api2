<?php

namespace App\Console\Commands\Dy;

use App\Models\Dy\Cookies;

class GrabCookies extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dy:GrabCookies {port?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '缓存cookies';

    /**
     * GrabFans constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @return array|bool|mixed|null
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');
        $arguments = $this->arguments();
        $this->port = $arguments['port'] ?? 5000;
        // 初始化客户端
        $this->initHttpClient($this->port);

        // 每秒钟抓取一次cookies
        $times = 1;
        while (1) {
            try {
                // 定时清理
                $times++;
                if ($times % 3700 == 0) {
                    Cookies::query()
                        ->where('expires_at', '<=', date('Y-m-d H:i:s'))
                        ->delete();
                }

                $proxiesIp = $this->getProxies();
                $responseData = $this->client->getCookies([], $proxiesIp);
                $cookies = $responseData['cookies'] ?? [];
                if (!empty($cookies)) {
                    (new Cookies([
                        'cookies' => $cookies,
                        'expires_at' => date('Y-m-d H:i:s', time() + 3600)
                    ]))->save();
                } else {
                    echo "抓取cookies失败" . PHP_EOL;
                }
            } catch (\Exception $exception) {
                echo "抓取cookies异常" . PHP_EOL;
            }
            sleep(1);
        }

        return true;
    }
}
