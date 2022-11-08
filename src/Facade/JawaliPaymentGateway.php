<?php

namespace Alsharie\JawaliPayment\Facade;

use Illuminate\Support\Facades\Facade;
use Alsharie\JawaliPayment\Jawali;

class JawaliPaymentGateway extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     */
    protected static function getFacadeAccessor()
    {
        return Jawali::class;
    }
}