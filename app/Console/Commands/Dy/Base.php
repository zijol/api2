<?php

namespace App\Console\Commands\Dy;

use App\Services\Cache\{
    DyCookiesCache, DyProxiesIpCache
};
use App\Models\Dy\{
    RawUser, User, UserFollowers, VUser
};
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

    protected $port = 5000;
    /**
     * @var Client
     */
    protected $client = null;
    protected $cookie = [];
    protected $proxiesIndex = 0;
    protected $proxiesPool = [];
    protected $sleepSecond = 1000000;

    const FIELDS_LIST = [
        'short_id', 'uid', 'unique_id', 'user_mode', 'ins_id', 'birthday', 'signature', 'gender', 'school_name', 'region', 'is_phone_binded', 'bind_phone',
        'sec_uid', 'twitter_id', 'youtube_channel_title', 'is_gov_media_vip', 'live_commerce', 'account_region', 'user_period', 'is_binded_weibo', 'cv_level',
        'live_agreement', 'weibo_schema', 'birthday_hide_level', 'create_time', 'google_account', 'constellation', 'is_mirror', 'need_recommend',
        'room_id', 'has_orders', 'reflow_page_uid', 'language', 'school_type', 'twitter_name', 'weibo_verify', 'with_fusion_shop_entry', 'youtube_channel_id',
        'user_rate_map', 'enterprise_verify_reason', 'story_open', 'user_rate', 'live_verify', 'short_id', 'secret', 'is_verified', 'with_commerce_entry',
        'has_email', 'weibo_url', 'weibo_name', 'commerce_user_level', 'verify_info', 'apple_account', 'verification_type', 'follower_status',
        'neiguang_shield', 'authority_status', 'is_ad_fake', 'nickname', 'is_star_atlas', 'custom_verify', 'user_canceled', 'status',
    ];

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
     * 初始化 http_client
     * @param $port
     * @param int $timeout
     */
    protected function initHttpClient($port, $timeout = 5)
    {
        $this->client = new Client([
            'base_uri' => "http://127.0.0.1:{$port}",
            'timeout' => $timeout,
        ]);
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
        $tryTimes = 0;
        while ($tryTimes < 3) {
            try {
                $tryTimes++;
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
                return $cookie;
            } catch (\Exception $exception) {
                echo "获取 cookies 异常 " . $exception->getMessage() . PHP_EOL;
                echo "再次尝试获取cookie" . PHP_EOL;
                usleep($this->sleepSecond);
                continue;
            }
        }
        return "";
    }

    /**
     * 获取用户信息
     *
     * @param $uid
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getUserInfo($uid)
    {
        $tryTimes = 0;
        while ($tryTimes < 3) {
            $tryTimes++;
//            echo "【查询用户】第 {$tryTimes} 次尝试 【{$uid}】" . PHP_EOL;
            try {
                $uri = "/douyin/get_user_info?user_id={$uid}&cookies=" . json_encode($this->getCookie());
                // 获取随即代理
                $proxiesIp = $this->getProxies();
                if (!empty($proxiesIp)) {
                    $uri .= "&proxies={$proxiesIp}";
                }

                $response = $this->client->request('GET', $uri, []);
                $responseBody = $response->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                if (!isset($responseData['code']) || 200 != $responseData['code']) {
                    echo "第 {$tryTimes} 次【查询用户】接口错误：" . $responseData['msg'] . PHP_EOL;
                    usleep($this->sleepSecond);
                    continue;
                } else {
                    $data = $responseData['data']['user'] ?? [];
                    if (empty($data)) {
                        echo "第 {$tryTimes} 次【查询用户】未查询到数据 {$uid}" . PHP_EOL;
                        $this->freshCookie();
                        usleep($this->sleepSecond);
                        continue;
                    }
                    return $data;
                }
            } catch (\Exception $exception) {
                echo "第 {$tryTimes} 次【查询用户】接口异常：" . $exception->getMessage() . PHP_EOL;
                usleep($this->sleepSecond);
                continue;
            }
        }

        return [];
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
     * @param $uid
     * @param $data
     * @param int $searchLevel
     * @param string $searchBase
     * @return bool
     */
    protected function saveVUser($uid, $data, $searchLevel = 0, $searchBase = '')
    {
        if (empty(VUser::query()->find($uid))) {
            (new VUser([
                'id' => $uid,
                'short_id' => $data['short_id'] ?? '',
                'unique_id' => $data['unique_id'] ?? '',
                'nickname' => $data['nickname'] ?? '',
                'gender' => $data['gender'] ?? '',
                'search_level' => intval($searchLevel),
                'search_base' => $searchBase
            ]))->save();
        }
        return true;
    }

    /**
     * @param $uid
     * @param $data
     * @return bool
     */
    protected function saveUser($uid, $data)
    {
        if (empty(User::query()->find($uid))) {
            (new User([
                'id' => $uid,
                'short_id' => $data['short_id'] ?? '',
                'unique_id' => $data['unique_id'] ?? '',
                'nickname' => $data['nickname'] ?? '',
                'gender' => $data['gender'] ?? '',
            ]))->save();
        }

        $rawData = [];
        foreach (static::FIELDS_LIST as $field) {
            $rawData[$field] = $data[$field] ?? null;
        }
        RawUser::query()->updateOrCreate(['id' => $uid,], ['raw_data' => $rawData]);
        return true;
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
//                echo "代理: " . $ip['ip'] . ":" . $ip['port'] . PHP_EOL;
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
