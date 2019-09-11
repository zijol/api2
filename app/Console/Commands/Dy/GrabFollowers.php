<?php

namespace App\Console\Commands\Dy;

use App\Models\Dy\VUser;

class GrabFollowers extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dy:GrabFollowers {keywords}';

    protected $keywords = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取关注用户';

    protected $hasMore = true;
    protected $followingNextTime = 0;
    protected $followingsTotal = 100;
    protected $tryTimes = 1;

    /**
     * GrabFollowers constructor.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');
        $arguments = $this->arguments();
        $this->keywords = $arguments['keywords'] ?? "60292541813";
        $this->getCookie();

        $user = $this->getUserInfo();
        if (isset($user['uid'])) {
            $this->saveUser($user['uid'], $user);
            $this->saveVUser($user['uid'], $user);
        }
        usleep($this->sleepSecond);

        if (empty($user)) {
            echo "未查询到用户 {$this->keywords}" . PHP_EOL;
            exit();
        }

        // 第一轮关注列表
        echo "正在进行第一轮关注列表" . PHP_EOL;
        $this->hasMore = true;
        $this->followingNextTime = time();

        $count = 0;
        while ($this->hasMore) {
            $followings = $this->getFollowList($user['uid']);
            foreach ($followings as $follow) {
                if (isset($follow['uid'])) {
                    $count++;
                    // 如果关注的是自己
                    if ($follow['uid'] == $user['uid'])
                        continue;
                    $this->saveVUser($follow['uid'], $follow, 1, $user['uid']);
                    $this->saveUser($follow['uid'], $follow);
                    $this->saveRelations($user['uid'], $follow['uid']);
                }
            }
            usleep($this->sleepSecond);
            if ($count >= $this->followingsTotal)
                break;
            else
                echo "$count / {$this->followingsTotal} 【{$user['uid']}】" . PHP_EOL;
        }

        // 第二轮关注列表
        echo "正在进行第二轮关注列表" . PHP_EOL;
        VUser::query()
            ->select(['id'])
            ->where([
                'search_level' => 1,
                'search_base' => $user['uid']
            ])->chunk(100, function ($vUserList) use ($user) {
                foreach ($vUserList as $vUser) {
                    $count = 0;
                    $this->hasMore = true;
                    $this->followingNextTime = time();
                    while ($this->hasMore) {
                        $followings = $this->getFollowList($vUser['id']);
                        foreach ($followings as $follow) {
                            if (isset($follow['uid'])) {
                                $count++;
                                // 如果关注的是自己
                                if ($follow['uid'] == $vUser['id'])
                                    continue;
                                $this->saveVUser($follow['uid'], $follow, 2, $user['uid']);
                                $this->saveUser($follow['uid'], $follow);
                                $this->saveRelations($vUser['id'], $follow['uid']);
                            }
                        }
                        unset($followings);
                        usleep($this->sleepSecond);
                        if ($count >= $this->followingsTotal)
                            break;
                        else
                            echo "$count / {$this->followingsTotal} 【{$vUser['id']}】" . PHP_EOL;
                    }
                }
            });

        // 第三轮关注列表
//        echo "正在进行第三轮关注列表" . PHP_EOL;
//        VUser::query()
//            ->select(['id'])
//            ->where([
//                'search_level' => 2,
//                'search_base' => $user['uid']
//            ])->chunk(100, function ($vUserList) use ($user) {
//                foreach ($vUserList as $vUser) {
//                    $count = 0;
//                    $this->hasMore = true;
//                    $this->followingNextTime = time();
//                    while ($this->hasMore) {
//                        $followings = $this->getFollowList($vUser['id']);
//                        foreach ($followings as $follow) {
//                            if (isset($follow['uid'])) {
//                                $count++;
//                                // 如果关注的是自己
//                                if ($follow['uid'] == $vUser['id'])
//                                    continue;
//                                $this->saveVUser($follow['uid'], $follow, 3, $user['uid']);
//                                $this->saveUser($follow['uid'], $follow);
//                                $this->saveRelations($vUser['id'], $follow['uid']);
//                            }
//                        }
//                        unset($followings);
//                        usleep($this->sleepSecond);
//                        if ($count >= $this->followingsTotal)
//                            break;
//                        else
//                            echo "$count / {$this->followingsTotal} 【{$vUser['id']}】" . PHP_EOL;
//                    }
//                }
//            });

        return true;
    }

    /**
     * 获取用户列表
     *
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserInfo()
    {
        $tryTimes = 0;
        while ($tryTimes < 3) {
            $tryTimes++;
            echo "【查询用户】第 {$tryTimes} 次尝试 【{$this->keywords}】" . PHP_EOL;
            try {
                $uri = "/douyin/get_user_info?user_id={$this->keywords}&cookies=" . json_encode($this->getCookie());
                // 获取随即代理
                $proxiesIp = $this->getProxies();
                if (!empty($proxiesIp)) {
                    $uri .= "&proxies={$proxiesIp}";
                }
                $response = $this->client->request('GET', $uri, []);
                $responseBody = $response->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                if (!isset($responseData['code']) || 200 != $responseData['code']) {
                    echo "【查询用户】接口错误：" . $responseData['msg'] . PHP_EOL;
                    usleep($this->sleepSecond);
                    continue;
                } else {
                    $this->hasMore = $responseData['data']['has_more'] ?? false;
                    $data = $responseData['data']['user'] ?? [];
                    if (empty($data)) {
                        echo "【查询用户】未查询到数据 {$this->keywords}" . PHP_EOL;
                        $this->freshCookie();
                        usleep($this->sleepSecond);
                        continue;
                    } else {
                        echo "【查询用户】正常" . PHP_EOL;
                    }
                    return $data;
                }
            } catch (\Exception $exception) {
                echo "【查询用户】接口异常：" . $exception->getMessage() . PHP_EOL;
                usleep($this->sleepSecond);
                continue;
            }
        }

        return [];
    }

    /**
     * @param $uid
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFollowList($uid)
    {
        $tryTimes = 0;
        while ($tryTimes < 3) {
            ++$tryTimes;
            echo "【关注列表】第 {$tryTimes} 次尝试 【{$uid}】" . PHP_EOL;
            try {
                $uri = "/douyin/get_following_list?user_id={$uid}&cookies=" . json_encode($this->getCookie()) . "&max_time={$this->followingNextTime}";
                // 获取随即代理
                $proxiesIp = $this->getProxies();
                if (!empty($proxiesIp)) {
                    $uri .= "&proxies={$proxiesIp}";
                }
                $response = $this->client->request('GET', $uri, []);
                $responseBody = $response->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                if (!isset($responseData['code']) || 200 != $responseData['code']) {
                    echo "【关注列表】接口错误:" . $responseData['msg'] . PHP_EOL;
                    usleep($this->sleepSecond);
                    continue;
                } else {
                    if (isset($responseData['data']['min_time']))
                        $this->followingNextTime = $responseData['data']['min_time'];

                    $this->hasMore = $responseData['data']['has_more'] ?? false;
                    $this->followingsTotal = $responseData['data']['total'] ?? 0;
                    $data = $responseData['data']['followings'] ?? [];
                    if (empty($data)) {
                        echo "【关注列表】未查询到数据 {$uid}" . PHP_EOL;
                        $this->freshCookie();
                        usleep($this->sleepSecond);
                        continue;
                    } else {
                        echo "【关注列表】正常" . PHP_EOL;
                    }
                    return $data;
                }
            } catch (\Exception $exception) {
                echo "【关注列表】接口异常：" . $exception->getMessage() . PHP_EOL;
                usleep($this->sleepSecond);
                continue;
            }
        }

        return [];
    }
}
