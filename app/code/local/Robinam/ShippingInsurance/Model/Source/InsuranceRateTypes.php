<?php

class Robinam_ShippingInsurance_Model_Source_InsuranceRateTypes
{
    const FIXED = 1;
    const PERCENT = 2;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::FIXED, 'label'=>Mage::helper('shippinginsurance')->__('Fixed rate')),
            array('value' => self::PERCENT, 'label'=>Mage::helper('shippinginsurance')->__('Percent rate')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            self::FIXED => Mage::helper('shippinginsurance')->__('Fixed rate'),
            self::PERCENT => Mage::helper('shippinginsurance')->__('Percent rate'),
        );
    }

}
