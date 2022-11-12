<?php

namespace Alsharie\JawaliPayment\Responses;


class JawaliEcommcaShoutResponse extends JawaliResponse
{


    public function getAmount($attr = null)
    {
        return $this->responseBody('amount');
    }


    public function getRefId($attr = null)
    {
        return $this->responseBody('refId');
    }

    public function getIssuerRef($attr = null)
    {
        return $this->responseBody('IssuerRef');
    }


}