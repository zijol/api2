<?php

namespace App\Console\Commands\Dy;

use App\Services\Cache\AppCache\DyCookiesCache;
use App\Services\Cache\AppCache\DyProxiesIpCache;
use Common\Model\Dy\RawUser;
use Common\Model\Dy\User;
use Common\Model\Dy\UserFollowers;
use Common\Model\Dy\VUser;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class Base extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dy:base';

    protected $baseUri = 'http://127.0.0.1:5000';
    protected $timeOut = 5.0;
    protected $client = null;
    protected $cookie = [];
    protected $proxiesIndex = 0;
    protected $proxiesPool = [];
    protected $sleepSecond = 0.1 * 1000000;

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
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'timeout' => $this->timeOut,
        ]);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return true;
    }

    /**
     * @return bool|mixed|null|string
     */
    protected function getCookie()
    {
        while (1) {
            try {
                $cookie = (new DyCookiesCache([]))->getWithSet(function () {
                    $uri = '/douyin/get_cookies';
                    $proxiesIp = $this->getProxies();
                    if (!empty($proxiesIp)) {
                        $uri .= "?proxies={$proxiesIp}";
                    }

                    $response = $this->client->request('GET', $uri, []);
                    $responseBody = $response->getBody()->getContents();
                    $responseData = json_decode($responseBody, true);
                    if (!isset($responseData['code']) || 200 != $responseData['code']) {
                        echo "获取 cookies 报错 " . $responseData['msg'] . PHP_EOL;
                        return null;
                    } else {
                        $this->cookie = $responseData['data']['cookies'] ?? [];
                        return $this->cookie;
                    }
                });
                if (empty($cookie)) {
                    echo "再次尝试获取cookie" . PHP_EOL;
                    usleep($this->sleepSecond);
                    continue;
                }
                return $cookie;
            } catch (\Exception $exception) {
                echo "获取 cookies 异常 " . $exception->getMessage() . PHP_EOL;
                echo "再次尝试获取cookie" . PHP_EOL;
                usleep($this->sleepSecond);
                continue;
            }
        }
    }

    /**
     * 刷新cookie
     *
     * @return int|null
     */
    protected function freshCookie()
    {
        return (new DyCookiesCache([]))->del();
    }

    /**
     * 更新大V用户
     *
     * @param $uid
     * @param $data
     * @param int $searchLevel
     * @param string $searchBase
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function saveVUser($uid, $data, $searchLevel = 0, $searchBase = '')
    {
        $userData = [
            'short_id' => $data['short_id'] ?? '',
            'unique_id' => $data['unique_id'] ?? '',
            'nickname' => $data['nickname'] ?? '',
            'gender' => $data['gender'] ?? '',
            'aweme_count' => $data['aweme_count'] ?? '',
            'following_count' => $data['following_count'] ?? '',
            'favoriting_count' => $data['favoriting_count'] ?? '',
            'total_favorited' => $data['total_favorited'] ?? '',
            'is_phone_binded' => $data['is_phone_binded'] ?? '',
            'bind_phone' => $data['bind_phone'] ?? '',
            'search_level' => intval($searchLevel),
            'search_base' => $searchBase
        ];
        return VUser::query()->updateOrCreate(['id' => $uid], $userData);
    }

    /**
     * 更新用户
     *
     * @param $uid
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function saveUser($uid, $data)
    {
        $userData = [
            'short_id' => $data['short_id'] ?? '',
            'unique_id' => $data['unique_id'] ?? '',
            'nickname' => $data['nickname'] ?? '',
            'gender' => $data['gender'] ?? '',
            'aweme_count' => $data['aweme_count'] ?? '',
            'following_count' => $data['following_count'] ?? '',
            'favoriting_count' => $data['favoriting_count'] ?? '',
            'total_favorited' => $data['total_favorited'] ?? '',
            'is_phone_binded' => $data['is_phone_binded'] ?? '',
            'bind_phone' => $data['bind_phone'] ?? ''
        ];
        RawUser::query()->updateOrCreate(['id' => $uid], ['raw_data' => json_encode($data)]);
        return User::query()->updateOrCreate(['id' => $uid], $userData);
    }

    /**
     * 保存关系
     *
     * @param $uid
     * @param $followTarget
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function saveRelations($uid, $followTarget)
    {
        return UserFollowers::query()
            ->updateOrCreate([
                'uid' => $uid,
                'follow_uid' => $followTarget
            ]);
    }

    /**
     * 获取代理IP
     * @return mixed
     */
    public function getProxies()
    {
        $proxiesIpCache = new DyProxiesIpCache([]);

        $proxiesIpPool = $proxiesIpCache->getWithSet(function () {
            $client = new Client([
                'base_uri' => 'http://http.tiqu.alicdns.com',
                'timeout' => 5.0,
            ]);
            $uri = '/getip3?num=20&type=2&pro=0&city=0&yys=100017&port=1&pack=63776&ts=1&ys=0&cs=0&lb=1&sb=0&pb=4&mr=1&regions=';
            $response = $client->request('GET', $uri, []);
            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);
            return $res['data'] ?? null;
        });

        if (empty($proxiesIpPool)) {
            echo "今日可用代理IP已用完" . PHP_EOL;
            return null;
        }

        while (1) {
            $ip = $proxiesIpPool[rand(0, count($proxiesIpPool) - 1)];
            if (strtotime($ip['expire_time']) < time()) {
                continue;
            } else {
                echo "代理: " . $ip['ip'] . ":" . $ip['port'] . PHP_EOL;
                return $ip['ip'] . ":" . $ip['port'];
            }
        }

        return null;
    }

    /**
     * 输出内存使用
     */
    protected function getMem()
    {
        echo "内存使用: " . floatval(memory_get_usage() / 1000000) . " Mb" . PHP_EOL;
    }
}
