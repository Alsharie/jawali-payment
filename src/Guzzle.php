<?php

namespace Alsharie\JawaliPayment;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Utils;
use Psr\Http\Message\ResponseInterface;

class Guzzle
{
    /**
     * Store guzzle client instance.
     *
     * @var Jawali
     */
    protected $guzzleClient;

    /**
     * Jawali payment base path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Store Jawali payment endpoint.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * BaseService Constructor.
     */
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $stack = new HandlerStack();
        $stack->setHandler(Utils::chooseHandler());
        $stack->push(\GuzzleHttp\Middleware::retry(
            function (
                $retries,
                \GuzzleHttp\Psr7\Request $request,
                \GuzzleHttp\Psr7\Response $response = null,
                $exception = null
            ) {
                $maxRetries = 5;

                if ($retries >= $maxRetries) {
                    return false;
                }

                if ($response && $response->getStatusCode() === 401) {
                    // received 401, so we need to refresh the token
                    $jawali = new Jawali;
                    $jawali->login();
                    return true;
                }

                if ($response && $response->getStatusCode() === 200) {

                    // received 200, but the wallet token is invalid
                    $invalid = 'invalid access token';
                    $expired = 'access token expired';
                    if (strpos(strtolower($response->getBody()->getContents()), $invalid) !== false
                        || strpos(strtolower($response->getBody()->getContents()), $expired) !== false) {
                        $jawali = new Jawali;
                        $jawali->walletAuth();
                        return true;
                    }

                }

                return false;
            }
        ));


        $this->guzzleClient = new Client([
            'handler' => $stack,
        ]);
        $this->basePath = config('jawali.url.base');


    }


    /**
     * @param $path
     * @param $attributes
     * @param string $method
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function sendRequest($path, $attributes, $headers, $security = [], string $request_type = 'json', string $method = 'POST'): ResponseInterface
    {

        if ($request_type == 'json')
            $headers['Content-Type'] = 'application/json';

        return $this->guzzleClient->request(
            $method,
            $path,
            [
                'headers' => array_merge(
                    $headers
                ),
                $request_type => $attributes,
                ...$security
            ]
        );
    }


    protected function getLoginPath(): string
    {
        return $this->basePath . '/' . "oauth/token";
    }


    protected function getWalletPath(): string
    {
        return $this->basePath . '/' . "v1/ws/callWS";
    }


}