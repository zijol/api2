<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-09-15
 * Time: 14:02
 */

namespace App\Services\Http;

use App\Exceptions\ForbiddenException;

class DouYinClient extends HttpClient
{
    /**
     * 获取cookies
     *
     * @param $params
     * @param string $proxies
     * @return mixed
     * @throws ForbiddenException
     */
    public function getCookies($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/get_cookies', $params));
    }

    /**
     * 获取粉丝列表
     *{
     * "user_id":"xxx",
     * "max_time":"xxxx",
     * "cookies":"{\"xxx\":\"xxx\"}",
     * "proxies":"xxx.xxx.xxx.xxx:xxx"
     * }
     * @param $params
     * @param string $proxies
     * @return mixed
     * @throws ForbiddenException
     */
    public function getFollowerList($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/get_following_list', $params));
    }

    /**
     * 获取粉丝列表
     *{
     * "user_id":"xxx",
     * "max_time":"xxxx",
     * "cookies":"{\"xxx\":\"xxx\"}",
     * "proxies":"xxx.xxx.xxx.xxx:xxx"
     * }
     * @param $params
     * @param string $proxies
     * @return mixed
     * @throws ForbiddenException
     */
    public function getFansList($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/get_follower_list', $params));
    }

    /**
     * 获取用户信息
     *{
     * "user_id":"xxx",
     * "cookies":"{\"xxx\":\"xxx\"}",
     * "proxies":"xxx.xxx.xxx.xxx:xxx"
     * }
     * @param $params
     * @param string $proxies
     * @return mixed
     * @throws ForbiddenException
     */
    public function getUserInfo($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/get_user_info', $params));
    }

    /**
     * 关注用户
     *{
     * "phonenumber":"+86xxxxxxxxxxx",
     * "user_id":""
     * }
     * @param $params
     * @param string $proxies
     * @return mixed
     * @throws ForbiddenException
     */
    public function followUser($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/follow_user', $params));
    }

    /**
     * 搜索用户
     * {
     * "keyword":"xxx",
     * "cursor":"xxxx",
     * "proxies":"xxx.xxx.xxx.xxx:xxx",
     * "cookies":"{\"xxx\":\"xxx\"}"
     * }
     * @param $params
     * @param string $proxies
     * @return mixed
     * @throws ForbiddenException
     */
    public function searchUser($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/search_user', $params));
    }

    /**
     * 响应统一处理
     *
     * @param array $result
     * @return mixed
     * @throws ForbiddenException
     */
    private function _result($result = [])
    {
        if ($result['exception'] instanceof \Exception) {
            throw $result['exception'];
        }

        $responseData = json_decode($result['content'], true);

        if ($responseData['code'] !== 200) {
            throw new ForbiddenException($responseData['msg']);
        }

        return $responseData['data'];
    }
}
