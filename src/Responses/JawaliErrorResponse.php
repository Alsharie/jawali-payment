<?php

namespace Alsharie\JawaliPayment\Responses;


class JawaliErrorResponse extends JawaliResponse
{
    protected $success = false;

    public function __construct($response, $status)
    {
        $this->data = (array) json_decode($response);
        $this->data['status_code'] = $status;
    }


}