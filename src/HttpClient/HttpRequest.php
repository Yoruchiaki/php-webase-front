<?php

namespace Yoruchiaki\WebaseFront\HttpClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;
use Yoruchiaki\WebaseFront\Interfaces\HttpRequestInterface;

class HttpRequest implements HttpRequestInterface
{
    private AppConfig $appConfig;
    private Client    $http;

    public function __construct(AppConfig $appConfig)
    {
        $this->appConfig = $appConfig;
        $this->http = new Client(
            [
                'base_uri' => $this->appConfig->frontUrl,
                'timeout'  => $this->appConfig->timeout
            ]
        );
    }

    /**
     * @throws GuzzleException
     */
    public function request(
        string $method,
        string $url,
        array $params = []
    ): array {
        $options = strtoupper($method) === 'POST' ? [
            'json' => $params
        ] : [
            'query' => array_merge($params),
        ];
        $response = $this->http->request(
            $method,
            $url,
            $options
        );
        if ($response->getReasonPhrase() === 'OK') {
            $content = $response->getBody()->getContents();
            try {
                $result = Utils::jsonDecode($content, true);
                if (is_array($result)) {
                    return $result;
                }
                return compact('result');
            } catch (Exception $exception) {
                return [
                    'result' => $content
                ];
            }
        }
        return Utils::jsonDecode($response->getBody()->getContents(), true);
    }
}