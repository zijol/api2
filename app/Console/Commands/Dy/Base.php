<?php

namespace App\Console\Commands\Dy;

use App\Services\Cache\{
    DyCookiesCache, DyProxiesIpCache
};
use App\Models\Dy\{
    Cookies, User, UserFollowers, VUser
};
use App\Services\Http\DouYinClient;
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
     * @var DouYinClient
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
        $this->client = new DouYinClient("http://127.0.0.1:{$port}", [], $timeout);
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
     * @return array
     */
    protected function getCookie()
    {
        // 从数据库获取已经缓存的 cookies
        $cookies = null;
        $second = 1;
        while (empty($cookies)) {
            $cookies = Cookies::query()
                ->where('err_times', "<", 10)
                ->where('expires_at', ">", date('Y-m-d H:i:s'))
                ->first();

            // 等待时间递增的方式进行获取cookie，保证cookies池子充足
            $sleep = ($second++ % 10) + 1;
            if ($sleep == 10) {
                echo "太久未获取到cookie，请检查cookie抓取进程是否异常" . PHP_EOL;
            }
            sleep($sleep);
        }

        return [
            'id' => empty($cookies) ? 0 : $cookies->id,
            'cookies' => empty($cookies) ? 0 : $cookies->cookies,
        ];
    }

    /**
     * 获取用户信息
     *
     * @param $uid
     * @return array
     */
    protected function getUserInfo($uid)
    {
        $tryTimes = 0;
        while ($tryTimes < 3) {
            $tryTimes++;
            try {
                $cookies = $this->getCookie();
                $responseData = $this->client->getUserInfo([
                    'user_id' => $uid,
                    'cookies' => json_encode($cookies['cookies'])
                ], $this->getProxies());

                $data = $responseData['user'] ?? [];
                if (empty($data)) {
                    echo "第 {$tryTimes} 次【查询用户】未查询到数据 {$uid}" . PHP_EOL;
                    $this->freshCookie($cookies['id']);
                    usleep($this->sleepSecond);
                    continue;
                }
                return $data;
            } catch (\Exception $exception) {
                echo "第 {$tryTimes} 次【查询用户】接口异常：" . $exception->getMessage() . PHP_EOL;
                echo $exception->getFile() . $exception->getLine() . PHP_EOL;
                usleep($this->sleepSecond);
                continue;
            }
        }

        return [];
    }

    /**
     * @param $cookiesId
     * @return mixed
     */
    protected function freshCookie($cookiesId)
    {
        $cookies = Cookies::query()->where('id', '=', $cookiesId)->first();

        if (!empty($cookies)) {
            if ($cookies->err_times >= 10 || $cookies->expires_at <= date('Y-m-d H:i:s')) {
                $cookies->delete();
            } else {
                $cookies->err_times = $cookies->err_times + 1;
                $cookies->save();
            }
        }

        return $cookiesId;
    }

    /**
     * @param $uid
     * @param $data
     * @param int $searchLevel
     * @param string $searchBase
     * @return bool
     */
    protected function saveVUser($uid, $data = [], $searchLevel = 0, $searchBase = '')
    {
        if (empty(VUser::query()->find($uid))) {
            (new VUser([
                'id' => $uid,
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
        $tableFix = User::getTableFix($uid);
        if (empty(User::query($tableFix)->find($uid))) {
            (new User([
                'id' => $uid,
                'short_id' => $data['short_id'] ?? '',
                'unique_id' => $data['unique_id'] ?? '',
                'nickname' => $data['nickname'] ?? '',
                'gender' => $data['gender'] ?? '',
                'avatar_uri' => $data['avatar_uri'] ?? '',
                'birthday' => $data['birthday'] ?? '',
                'constellation' => $data['constellation'] ?? 0,
                'signature' => $data['signature'] ?? '',
                'school_name' => $data['school_name'] ?? '',
                'has_orders' => $data['has_orders'] ? intval($data['has_orders']) : 0,
                'room_id' => isset($data['room_id']) ? intval($data['room_id']) : '',
                'verification_info' => isset($data['verification_info']) ? $data['verification_info'] : '',
            ], $tableFix))->save();
        }
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
        $proxiesIpCache = new DyProxiesIpCache();

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
