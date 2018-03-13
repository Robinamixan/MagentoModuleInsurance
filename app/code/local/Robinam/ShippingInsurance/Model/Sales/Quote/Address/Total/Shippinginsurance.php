<?php

class Robinam_ShippingInsurance_Model_Sales_Quote_Address_Total_Shippinginsurance extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'shippinginsurance';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        $this->_setAmount(0);
        $this->_setBaseAmount(0);

        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this; //this makes only address type shipping to come through
        }

        $quote = $address->getQuote();

        if (Robinam_ShippingInsurance_Model_ShippingInsurance::canApply($address)) { //your business logic
            $exist_amount = $quote->getShippinginsuranceAmount();
            $fee = Robinam_ShippingInsurance_Model_ShippingInsurance::getShippinginsurance($address);
            $balance = $fee - $exist_amount;
            $address->setShippinginsuranceAmount($balance);
            $address->setBaseShippinginsuranceAmount($balance);

            $quote->setShippinginsuranceAmount($balance);

            $address->setGrandTotal($address->getGrandTotal() + $address->getShippinginsuranceAmount());
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBaseShippinginsuranceAmount());
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amt = $address->getShippinginsuranceAmount();
        $address->addTotal(array(
            'code' => $this->getCode(),
            'title' => Mage::helper('shippinginsurance')->__('Shipping Insurance'),
            'value' => $amt,
        ));

        return $this;
    }
}
