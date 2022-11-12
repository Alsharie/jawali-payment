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
        $stack = new HandlerStack();
        $stack->setHandler(Utils::chooseHandler());
        $stack->push(\GuzzleHttp\Middleware::retry(
            function (
                $retries,
                \GuzzleHttp\Psr7\Request $request,
                \GuzzleHttp\Psr7\Response $response = null,
                \GuzzleHttp\Exception\RequestException $exception = null
            ) {
                $maxRetries = 5;

                if ($retries >= $maxRetries) {
                    return false;
                }

                if ($response && $response->getStatusCode() === 401) {
                    // received 401, so we need to refresh the token
                    // this should call your custom function that requests a new token and stores it somewhere (cache)
                    $jawali = new Jawali;
                    $jawali->login();
                    return true;
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
    protected function sendRequest($path, $attributes, $headers, $security = [], string $method = 'POST'): ResponseInterface
    {

        return $this->guzzleClient->request(
            $method,
            $path,
            [
                'headers' => array_merge(
                    $headers
                ),
                'form_params' => $attributes,
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