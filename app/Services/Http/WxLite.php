<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/11
 * Time: 14:40
 */

namespace App\Services\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Redis;

/**
 * Class WxLite
 *
 * Demo小程序调用微信开放接口类
 *
 * @package App\Services\Http
 */
class WxLite
{
    const APP_ID = 'wx4f8ba2409f306867';
    const APP_SECRET = '08a5f5ee54c94efbb0b59c46fce011fe';
    const BASE_URI = "https://api.weixin.qq.com";
    const TIMEOUT = 5.0;

    /**
     * 获取token
     *
     * @param boolean $forceGetFromRemote 强行从远程获取AccessToken
     * @return string
     */
    public static function getAccessToken($forceGetFromRemote = false)
    {
        // 检查Redis中是否已经存在
        if (!$forceGetFromRemote) {
            $redisSaveAccessToken = Redis::connection('default')->get('wx_access_token');
            if ($redisSaveAccessToken) {
                return $redisSaveAccessToken;
            }
        }

        $accessToken = null;
        $expiredTime = 100;

        try {
            // 请求获取token
            $client = new Client([
                'base_uri' => self::BASE_URI,
                'timeout' => self::TIMEOUT,
            ]);

            $uri = self::BASE_URI . "/cgi-bin/token?" . http_build_query([
                    'appid' => self::APP_ID,
                    'secret' => self::APP_SECRET,
                    'grant_type' => 'client_credential'
                ]);

            $response = $client->request('GET', $uri, [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'http_errors' => true
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['access_token'])) {
                $accessToken = $result['access_token'];
            }
            if (isset($result['expires_in']) && $result['expires_in'] > 100) {
                $expiredTime = $result['expires_in'] - 100;
            }
        } catch (RequestException $e) {
            $accessToken = null;
            $expiredTime = 1;
        } catch (GuzzleException $e) {
            $accessToken = null;
            $expiredTime = 1;
        }

        // 将token存储到Redis
        Redis::connection('default')->setex('wx_access_token', $expiredTime, $accessToken);
        return $accessToken;
    }

    /**
     * 发送模板消息
     *
     * @param array $templateData
     * @return string
     */
    public static function sendTemplateMessage($templateData = [])
    {
        $token = self::getAccessToken();
        $uri = '/cgi-bin/message/wxopen/template/send?access_token=' . $token;

        $client = new Client([
            'base_uri' => self::BASE_URI,
            'timeout' => self::TIMEOUT,
        ]);

        try {
            $response = $client->request('POST', $uri, [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'http_errors' => true,
                'json' => $templateData
            ]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return json_encode([
                'errCode' => '4xx',
                'errMessage' => $e->getMessage()
            ]);
        } catch (GuzzleException $e) {
            return json_encode([
                'errCode' => '5xx',
                'errMessage' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'errCode' => '1xx',
                'errMessage' => $e->getMessage()
            ]);
        }
    }
}
