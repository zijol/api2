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
    protected $signature = 'Dy:GrabFollowers {port} {user_id}';
    protected $userId = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取关注用户';
    protected $hasMore = true;
    protected $followingNextTime = 0;
    protected $followingsTotal = 100;

    /**
     * GrabFollowers constructor.
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
        $this->userId = $arguments['user_id'] ?? "60292541813";
        $this->port = $arguments['port'] ?? 5000;

        // 初始化客户端
        $this->initHttpClient($this->port);
        $this->getCookie();

        $user = $this->getUserInfo($this->userId);
        if (isset($user['uid'])) {
            $this->saveUser($user['uid'], $user);
            $this->saveVUser($user['uid'], $user);
        }
        usleep($this->sleepSecond);

        if (empty($user)) {
            echo "未查询到用户 {$this->userId}" . PHP_EOL;
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
        echo "正在进行第三轮关注列表" . PHP_EOL;
        VUser::query()
            ->select(['id'])
            ->where([
                'search_level' => 2,
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
                                $this->saveVUser($follow['uid'], $follow, 3, $user['uid']);
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

        return true;
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
            try {
                $responseData = $this->client->getFollowerList([
                    'user_id' => $uid,
                    'cookies' => json_encode($this->getCookie()),
                    'max_time' => $this->followingNextTime
                ], $this->getProxies());

                if (isset($responseData['min_time']))
                    $this->followingNextTime = $responseData['min_time'];
                $this->hasMore = $responseData['has_more'] ?? false;
                $this->followingsTotal = $responseData['total'] ?? 0;
                $data = $responseData['followings'] ?? [];
                if (empty($data)) {
                    echo "第 {$tryTimes} 次【关注列表】未查询到数据 {$uid}" . PHP_EOL;
                    $this->freshCookie();
                    usleep($this->sleepSecond);
                    continue;
                }
                return $data;
            } catch (\Exception $exception) {
                echo "第 {$tryTimes} 次【关注列表】接口异常：" . $exception->getMessage() . PHP_EOL;
                usleep($this->sleepSecond);
                continue;
            }
        }

        return [];
    }
}
