<?php

namespace App\Console\Commands\Dy;

use App\Models\Dy\VUser;
use Illuminate\Database\Eloquent\Builder;

class GrabFans extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dy:GrabFans {port} {user_id} {grab_times?}';

    protected $userId = '';
    protected $grabTimes = 1;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取粉丝用户';

    protected $hasMore = true;
    protected $fansNextTime = 0;
    protected $fansListTotal = 100;

    /**
     * GrabFans constructor.
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
        $this->grabTimes = $arguments['grab_times'] ?? 1;
        $this->port = $arguments['port'] ?? 5000;

        // 初始化客户端
        $this->initHttpClient($this->port);

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

        while (1) {
            $vu = VUser::query()
                ->where(function (Builder $subQuery) use ($user) {
                    $subQuery->where('search_base', '=', $user['uid'])
                        ->orWhere('id', '=', $user['uid']);
                })->where('grab_fans', '<', $this->grabTimes)
                ->orderBy('search_level', 'asc')
                ->first();

            if (empty($vu)) {
                echo "{$user['uid']} 的所有关注用户已经爬过粉丝" . PHP_EOL;
                exit();
            }

            $count = 0;
            $this->hasMore = true;
            $this->fansNextTime = time();
            while ($this->hasMore) {
                $fansList = $this->getFansList($vu['id']);
                foreach ($fansList as $fans) {
                    if (isset($fans['uid'])) {
                        $count++;
                        $this->saveUser($fans['uid'], $fans);
                        $this->saveRelations($fans['uid'], $vu['id']);
                    }
                }
                $this->getMem();
                unset($fansList);
                usleep($this->sleepSecond);
                if ($count >= $this->fansListTotal)
                    break;
                else
                    echo "$count / {$this->fansListTotal} 【{$vu['id']}】 粉丝列表" . PHP_EOL;
            }

            $vu->grab_fans = $vu->grab_fans + 1;
            $vu->save();
        }

        return true;
    }

    /**
     * 粉丝列表
     *
     * @param $uid
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFansList($uid)
    {
        $tryTimes = 0;
        while ($tryTimes < 100) {
            ++$tryTimes;
            try {
                $cookies = $this->getCookie();
                $responseData = $this->client->getFansList([
                    'user_id' => $uid,
                    'cookies' => json_encode($cookies['cookies']),
                    'max_time' => $this->fansNextTime
                ], $this->getProxies());

                if (isset($responseData['min_time']))
                    $this->fansNextTime = $responseData['min_time'];
                $this->hasMore = $responseData['has_more'] ?? false;
                $this->fansListTotal = $responseData['total'] ?? 0;
                $data = $responseData['followers'] ?? [];

                if (empty($data)) {
                    echo "第 {$tryTimes} 次【粉丝列表】未查询到数据 {$uid}" . PHP_EOL;
                    $this->freshCookie($cookies['id']);
                    usleep($this->sleepSecond);
                    continue;
                }
                return $data;
            } catch (\Exception $exception) {
                echo "第 {$tryTimes} 次【粉丝列表】接口异常：" . $exception->getMessage() . PHP_EOL;
                usleep($this->sleepSecond);
                continue;
            }
        }

        return [];
    }
}
