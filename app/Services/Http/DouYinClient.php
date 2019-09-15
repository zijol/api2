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
     * @throws \App\Exceptions\SystemException
     */
    public function getCookies($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/get_cookies', $params));
    }

    /**
     * 获取粉丝列表
     *
     * @param $params
     * @param string $proxies
     * @return mixed
     * @throws ForbiddenException
     * @throws \App\Exceptions\SystemException
     */
    public function getFollowerList($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/get_following_list', $params));
    }

    /**
     * 获取粉丝列表
     *
     * @param $params
     * @param string $proxies
     * @return mixed
     * @throws ForbiddenException
     * @throws \App\Exceptions\SystemException
     */
    public function getFansList($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/get_follower_list', $params));
    }

    /**
     * 获取用户信息
     *
     * @param $params
     * @param string $proxies
     * @return mixed
     * @throws ForbiddenException
     * @throws \App\Exceptions\SystemException
     */
    public function getUserInfo($params, $proxies = '')
    {
        empty($proxies) ?: $params['proxies'] = $proxies;
        return $this->_result($this->get('/douyin/get_user_info', $params));
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