<?php

class Robinam_ShippingInsurance_Model_Sales_Quote_Address_Total_Shippinginsurance extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'shippinginsurance';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        $insuranceModel = Mage::getModel('shippinginsurance/insurance');

        $this->_setAmount(0);
        $this->_setBaseAmount(0);

        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this; //this makes only address type shipping to come through
        }

        $quote = $address->getQuote();

        if ($insuranceModel->canChangeInsuranceAmount($address)) {
            $exist_amount = $quote->getShippinginsuranceAmount();
            $insuranceRate = $insuranceModel->getInsuranceRate($address);
            $balance = $insuranceRate - $exist_amount;
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
