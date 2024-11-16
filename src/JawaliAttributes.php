<?php

namespace Alsharie\JawaliPayment;


use Alsharie\JawaliPayment\Helpers\JawaliAuthHelper;

class JawaliAttributes extends Guzzle
{

    /**
     * Store request attributes.
     */
    protected array $attributes = [];

    protected array $headers = [];
    protected array $security = [];


    /**
     * for test purposes
     * @return $this
     */
    public function disableVerify(): JawaliAttributes
    {
        $this->security['verify'] = false;
        return $this;
    }

    /**
     * @param $voucher
     * @return JawaliAttributes
     */
    public function setVoucher($voucher): JawaliAttributes
    {
        $this->attributes['body']['voucher'] = $voucher;
        return $this;
    }

    //set currency
    public function setCurrency($currency): JawaliAttributes
    {
        $this->attributes['body']['currency'] = $currency;
        return $this;
    }

    /**
     * set receiver mobile when refund
     * @param $phone
     * @return JawaliAttributes
     */
    public function setReceiverMobile($phone): JawaliAttributes
    {
        $this->attributes['body']['receiverMobile'] = $phone;
        return $this;
    }


    /**
     * @param $id
     * @return JawaliAttributes
     */
    public function setRefId($id): JawaliAttributes
    {
        $this->attributes['body']['refId'] = $id;
        return $this;
    }


    /**
     * @param $ref
     * @return JawaliAttributes
     */
    public function setIssuerRef($ref): JawaliAttributes
    {
        $this->attributes['body']['issuerRef'] = $ref;
        return $this;
    }


    /**
     * @param $amount
     * @return JawaliAttributes
     */
    public function setAmount($amount): JawaliAttributes
    {
        $this->attributes['body']['amount'] = $amount;
        return $this;
    }


    /**
     * set the purpose
     * @param $note
     * @return JawaliAttributes
     */
    public function setNote($note): JawaliAttributes
    {
        $this->attributes['body']['purpose'] = $note;
        return $this;
    }

    /**
     * same as setNote('note')
     * @param $note
     * @return JawaliAttributes
     */
    public function setPurpose($note): JawaliAttributes
    {
        $this->attributes['body']['purpose'] = $note;
        return $this;
    }



    /**
     * @param array $attributes
     * @return JawaliAttributes
     */
    public function setAttributes(array $attributes): JawaliAttributes
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return JawaliAttributes
     */
    public function mergeAttributes(array $attributes): JawaliAttributes
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @return JawaliAttributes
     */
    public function setAttribute($key, $value): JawaliAttributes
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @param mixed $key
     *
     * @return boolean
     */
    public function hasAttribute($key): bool
    {
        return isset($this->attributes[$key]);
    }

    /**
     * @param mixed $key
     *
     * @return JawaliAttributes
     */
    public function removeAttribute($key): JawaliAttributes
    {
        $this->attributes = array_filter($this->attributes, function ($name) use ($key) {
            return $name !== $key;
        }, ARRAY_FILTER_USE_KEY);

        return $this;
    }


    /**
     * @return void
     */
    protected function setAuthAttributes()
    {


        $this->attributes['username'] = config('jawali.auth.username');
        $this->attributes['password'] = config('jawali.auth.password');

        $this->attributes['grant_type'] = "password";
        $this->attributes['client_id'] = "restapp";
        $this->attributes['client_secret'] = "restapp";
        $this->attributes['scope'] = "read";

    }

    /**
     * @return void
     */
    protected function setWalletLoginAttributes()
    {
        $this->attributes['body']['identifier'] = config('jawali.auth.wallet');
        $this->attributes['body']['password'] = config('jawali.auth.wallet_password');
    }

    /**
     * @return void
     */
    protected function setWalletAuthAttributes()
    {
        $this->attributes['body']['agentWallet'] = config('jawali.auth.wallet');
        $this->attributes['body']['password'] = config('jawali.auth.wallet_password');
        $this->attributes['body']['accessToken'] = JawaliAuthHelper::getWalletToken();
    }

    /**
     * @return void
     */
    protected function setServiceScope($service)
    {
        $this->attributes['header']['serviceDetail']['serviceName'] = $service;
    }
    /**
     * @return void
     */
    protected function setServiceDomain($domain)
    {
        $this->attributes['header']['serviceDetail']['domainName'] = $domain;
    }

    /**
     * @return void
     */
    protected function setsignnDetail()
    {

        $this->attributes['header']['signonDetail']['orgID'] = config('jawali.auth.org_id');
        $this->attributes['header']['signonDetail']['userID'] = config('jawali.auth.user_id');
        $this->attributes['header']['signonDetail']['externalUser'] = config('jawali.auth.external_user');
    }


    /**
     * @return void
     */
    protected function setAuthorization()
    {
        $this->headers['Authorization'] = 'bearer ' . JawaliAuthHelper::getAuthToken();
    }

}
