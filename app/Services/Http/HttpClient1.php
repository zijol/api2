<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/3/4
 * Time: 14:24
 */

namespace App\Services\Http;

use App\Exceptions\ForbiddenException;
use App\Exceptions\SystemException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use App\Services\Log\HttpServiceLog;

class HttpClient1
{
    private $base_uri = '';
    private $timeout = 5.0;
    private $headers = [];
    private $http_errors = true;

    public function __construct($base_uri, $headers = [], $timeout = 5.0, $http_errors = true)
    {
        $this->base_uri = $base_uri;
        $this->headers = $headers;
        $this->timeout = $timeout;
        $this->http_errors = $http_errors;
    }

    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->base_uri,
            'timeout' => $this->timeout,
            'headers' => $this->headers,
            'http_errors' => $this->http_errors
        ]);
    }

    /**
     * @param $uri
     * @param $params
     * @param $format
     * @return string
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function post($uri, $params, $format = 'form_params')
    {
        return $this->send('POST', $uri, $params, $format);
    }

    /**
     * @param $uri
     * @param $params
     * @return string
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function get($uri, $params)
    {
        return $this->send('GET', $uri, $params);
    }

    /**
     * @param $uri
     * @param $params
     * @param $format
     * @return string
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function put($uri, $params, $format = 'form_params')
    {
        return $this->send('PUT', $uri, $params, $format);
    }

    /**
     * @param $uri
     * @param $params
     * @return string
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function delete($uri, $params)
    {
        return $this->send('DELETE', $uri, $params);
    }

    /**
     * send 方法
     *
     * @param $method
     * @param $uri
     * @param $params
     * @param $format
     * @return string
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function send($method, $uri, $params, $format = 'form_params')
    {
        $client = $this->getClient();
        $requestOptions = [];

        // 如果是DELETE | GET
        if (in_array(strtoupper($method), ['GET', 'DELETE'])) {
            $requestOptions['query'] = $params;
            $realMethod = strtoupper($method);

            // 如果是DELETE | GET
        } elseif (in_array(strtoupper($method), ['POST', 'PUT'])) {
            if (in_array($format, ['body', 'json', 'form_params', 'multipart'])) {
                $requestOptions[$format] = $params;
            } else {
                $requestOptions['form_params'] = $params;
            }
            $realMethod = strtoupper($method);

            // 其他都使用GET
        } else {
            $requestOptions['query'] = $params;
            $realMethod = 'GET';
        }

        try {
            $httpServiceLogInfo = [
                'domain' => $this->base_uri,
                'uri' => $uri,
                'timeout' => $this->timeout,
                'method' => $realMethod,
                'format' => $format,
                'headers' => $this->headers,
                'params' => $params,
                'response' => [],
                'exception' => [],
            ];

            $response = $client->request($realMethod, $uri, $requestOptions);
            // 服务端错误 5xx
        } catch (ServerException $serverException) {
            $message = '系统错误';
            $code = 5000;
            $data = null;
            $httpCode = 500;
            if ($serverException->hasResponse()) {
                $response = $serverException->getResponse();
                $content = $response->getBody()->getContents();
                $httpCode = $response->getStatusCode();
                $httpServiceLogInfo['response'] = [
                    'headers' => json_encode($response->getHeaders(), JSON_UNESCAPED_UNICODE),
                    'status' => $response->getStatusCode(),
                    'content' => $content
                ];

                $tmp = json_decode($content, true);
                if (is_array($tmp)) {
                    $message = $tmp['message'] ?? $message;
                    $code = $tmp['code'] ?? $code;
                    $data = $tmp['data'] ?? $data;
                }
            }

            $httpServiceLogInfo['exception'] = $serverException;
            HttpServiceLog::Log($httpServiceLogInfo);
            throw new SystemException($message, $code, $data, null, $httpCode);

            // 客户端错误 4xx
        } catch (ClientException $clientException) {
            $message = '请求错误';
            $code = 4003;
            $data = null;
            $httpCode = 403;
            if ($clientException->hasResponse()) {
                $response = $clientException->getResponse();
                $content = $response->getBody()->getContents();
                $httpCode = $response->getStatusCode();
                $httpServiceLogInfo['response'] = [
                    'headers' => json_encode($response->getHeaders(), JSON_UNESCAPED_UNICODE),
                    'status' => $response->getStatusCode(),
                    'content' => $content
                ];

                $tmp = json_decode($content, true);
                if (is_array($tmp)) {
                    $message = $tmp['message'] ?? $message;
                    $code = $tmp['code'] ?? $code;
                    $data = $tmp['data'] ?? $data;
                }
            }

            $httpServiceLogInfo['exception'] = $clientException;
            HttpServiceLog::Log($httpServiceLogInfo);
            throw new ForbiddenException($message, $code, $data, null, $httpCode);

            // 请求过程中网络错误
        } catch (RequestException $requestException) {
            $message = '服务器网络错误';
            $code = 4000;
            $data = null;
            $httpCode = 400;
            if ($requestException->hasResponse()) {
                $response = $requestException->getResponse();
                $content = $response->getBody()->getContents();
                $httpCode = $response->getStatusCode();
                $httpServiceLogInfo['response'] = [
                    'headers' => json_encode($response->getHeaders(), JSON_UNESCAPED_UNICODE),
                    'status' => $response->getStatusCode(),
                    'content' => $content
                ];

                $tmp = json_decode($content, true);
                if (is_array($tmp)) {
                    $message = $tmp['message'] ?? $message;
                    $code = $tmp['code'] ?? $code;
                    $data = $tmp['data'] ?? $data;
                }
            }

            $httpServiceLogInfo['exception'] = $requestException;
            HttpServiceLog::Log($httpServiceLogInfo);
            throw new ForbiddenException($message, $code, $data, null, $httpCode);

            // 其他未知错误
        } catch (GuzzleException $exception) {

            HttpServiceLog::Log($httpServiceLogInfo);
            throw new SystemException('系统错误', 5000);
        }

        $content = $response->getBody()->getContents();
        $httpServiceLogInfo['response'] = [
            'headers' => json_encode($response->getHeaders(), JSON_UNESCAPED_UNICODE),
            'status' => $response->getStatusCode(),
            'content' => $content
        ];
        HttpServiceLog::Log($httpServiceLogInfo);

        return $content;
    }
}
