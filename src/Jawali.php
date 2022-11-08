<?php

namespace Alsharie\JawaliPayment;


use Alsharie\JawaliPayment\Helpers\JawaliAuthHelper;
use Alsharie\JawaliPayment\Responses\JawaliConfirmPaymentResponse;
use Alsharie\JawaliPayment\Responses\JawaliErrorResponse;
use Alsharie\JawaliPayment\Responses\JawaliInitPaymentResponse;
use Alsharie\JawaliPayment\Responses\JawaliLoginResponse;
use Alsharie\JawaliPayment\Responses\JawaliOperationStatusResponse;
use Alsharie\JawaliPayment\Responses\JawaliWalletAuthResponse;
use GuzzleHttp\Exception\GuzzleException;

class Jawali extends JawaliAttributes
{


    public function __construct()
    {
        $this->attributes['header'] = [
            "serviceDetail" => [
                "domainName" => "WalletDomain",
            ],
            "signonDetail" => [
                "clientID" => "WeCash",
            ],
            "messageContext" => [
                "clientDate" => "",
                "bodyType" => ""
            ],
        ];
        $this->attributes['body'] = [];
        $this->setsignnDetail();
//
//        [
//            "header" => [
//                "serviceDetail" => [
//
//                ],
//                "signonDetail" => [
//
//                    "orgID" => "22000001688",
//                    "userID" => "school.branch.api.test",
//                    "externalUser" => "user1"
//                ],
//                "messageContext" => [
//                    "clientDate" => "202211101156",
//                    "bodyType" => "Clear"
//                ]
//
//            ],
//            "body" => [
//                "agentWallet" => "22000001688",
//                "refId" => "1253",
//                "password" => "123456"
//            ]
//        ];


    }

    /**
     * login into the gateway to get the token
     * @return JawaliErrorResponse|JawaliLoginResponse
     */
    public function login()
    {
        // set `username`, and `password` , ...etc.
        $this->setAuthAttributes();

        try {
            $response = $this->sendRequest(
                $this->getLoginPath(),
                $this->attributes,
                $this->headers,
            );

            $response = new JawaliLoginResponse((string)$response->getBody());
            JawaliAuthHelper::setAuthToken($response->getAccessToken());
            return $response;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return new JawaliErrorResponse($e->getResponse()->getBody(), $e->getResponse()->getStatusCode());
        } catch (GuzzleException $e) {
            return new JawaliErrorResponse(json_encode(['message' => $e->getMessage()]), $e->getCode());
        }
    }

    /**
     * login into the gateway to get the token
     * @return JawaliErrorResponse|JawaliWalletAuthResponse
     */
    public function walletAuth()
    {

        $this->setAuthorization();
        $this->setWalletLoginAttributes();
        $this->setServiceScope('PAYWA.WALLETAUTHENTICATION');


        try {
            $response = $this->sendRequest(
                $this->getWalletPath(),
                $this->attributes,
                $this->headers,
            );

            $response = new JawaliWalletAuthResponse((string)$response->getBody());
            JawaliAuthHelper::setAuthToken($response->getAccessToken());
            return $response;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return new JawaliErrorResponse($e->getResponse()->getBody(), $e->getResponse()->getStatusCode());
        } catch (GuzzleException $e) {
            return new JawaliErrorResponse(json_encode(['message' => $e->getMessage()]), $e->getCode());
        }
    }

    /**
     * It Is used to allow the merchant to initiate a payment for a specific customer.
     * @return JawaliInitPaymentResponse|JawaliErrorResponse
     */
    public function ecommerceInquiry()
    {
        $this->setAuthorization();
        $this->setWalletAuthAttributes();
        $this->setServiceScope('PAYAG.ECOMMERCEINQUIRY');
        if (!isset($this->attributes['CurrencyId'])) {
            $this->attributes['CurrencyId'] = 2;//rial Yemeni
        }

        try {
            $response = $this->sendRequest(
                $this->getWalletPath(),
                $this->attributes,
                $this->headers,
            );

            return new JawaliInitPaymentResponse((string)$response->getBody());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return new JawaliErrorResponse($e->getResponse()->getBody(), $e->getResponse()->getStatusCode());
        } catch (GuzzleException $e) {
            return new JawaliErrorResponse(json_encode(['message' => $e->getMessage()]), $e->getCode());
        }
    }



}