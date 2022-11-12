<?php

namespace Alsharie\JawaliPayment\Responses;


class JawaliEcommerceInquiryResponse extends JawaliResponse
{


    public function getAmount($attr = null)
    {
        return $this->responseBody('txnamount');
    }


    public function getTransactionRef($attr = null)
    {
        return $this->responseBody('issuerTrxRef');
    }


}