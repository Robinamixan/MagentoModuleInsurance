<?php

class Robinam_ShippingInsurance_Model_Sales_Quote_Address_Total_Shippinginsurance extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'shippinginsurance';

    /** @var false|Robinam_ShippingInsurance_Model_ShippingInsurance $insuranceModel */
    protected $insuranceModel;

    public function __construct()
    {
        $this->insuranceModel = Mage::getModel('shippinginsurance/shippingInsurance');
    }

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        $this->_setAmount(0);
        $this->_setBaseAmount(0);

        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this; //this makes only address type shipping to come through
        }

        if ($this->insuranceModel->canChangeInsuranceAmount($address)) {
            $balance = $this->insuranceModel->getInsuranceRate($address);
            $this->setShippinginsuranceAmount($address, $balance);
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amt = $address->getShippinginsuranceAmount();
        if (!empty($amt)) {
            $address->addTotal([
                'code' => $this->getCode(),
                'title' => Mage::helper('shippinginsurance')->__('Shipping Insurance'),
                'value' => $amt,
                'type' => $this->insuranceModel->getInsuranceType($address),
            ]);
        }

        return $this;
    }

    protected function setShippinginsuranceAmount(Mage_Sales_Model_Quote_Address $address, float $balance)
    {
        $quote = $address->getQuote();
        $address->setShippinginsuranceAmount($balance);
        $address->setBaseShippinginsuranceAmount($balance);

        $quote->setShippinginsuranceAmount($balance);

        $address->setGrandTotal($address->getGrandTotal() + $balance);
        $address->setBaseGrandTotal($address->getBaseGrandTotal() + $balance);
    }
}
