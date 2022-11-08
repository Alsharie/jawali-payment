<?php

namespace Alsharie\JawaliPayment\Responses;


class JawaliResponse
{
    protected $success = true;
    /**
     * Store the response data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Response constructor.
     */
    public function __construct($response)
    {
        $this->data = (array)json_decode($response, true);
    }


    /**
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @return array
     */
    public function body()
    {
        return $this->data;
    }

    public function isSuccess()
    {
        if (isset($this->data['responseStatus'])) {
            if (isset($this->data['responseStatus']['systemStatus'])) {
                return $this->data['responseStatus']['systemStatus'] == 0;
            }
        }

        return $this->success;

    }

    public function responseBody($attr = null)
    {
        if (isset($this->data['responseBody'])) {
            if ($attr == null)
                return $this->data['responseBody'];

            if (isset($this->data['responseBody'][$attr]))
                return $this->data['responseBody'][$attr];

        }
    }


}