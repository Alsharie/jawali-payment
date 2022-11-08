<?php

namespace Alsharie\JawaliPayment\Responses;


class JawaliInitPaymentResponse extends JawaliResponse
{


    public function getSource($attr = null)
    {
        if (!empty($this->data['source'])) {
            if ($attr == null)
                return $this->data['source'];

            if (isset($this->data['source'][$attr]))
                return $this->data['source'][$attr];
        }
    }


    public function getAdjustment($attr = null)
    {
        if (!empty($this->data['adjustment'])) {
            if ($attr == null)
                return $this->data['adjustment'];

            if (isset($this->data['adjustment'][$attr]))
                return $this->data['adjustment'][$attr];
        }
    }


    public function getDestination($attr = null)
    {
        if (!empty($this->data['destination'])) {
            if ($attr == null)
                return $this->data['destination'];

            if (isset($this->data['destination'][$attr]))
                return $this->data['destination'][$attr];
        }
    }

}