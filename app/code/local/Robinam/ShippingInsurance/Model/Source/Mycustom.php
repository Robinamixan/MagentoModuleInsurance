<?php

class Robinam_ShippingInsurance_Model_Source_MyCustom
{
    const FIXED = 'fixed';
    const PERCENT = 'percent';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => $this::FIXED, 'label'=>Mage::helper('shippinginsurance')->__('Fixed rate')),
            array('value' => $this::PERCENT, 'label'=>Mage::helper('shippinginsurance')->__('Percent rate')),
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
            $this::FIXED => Mage::helper('shippinginsurance')->__('Fixed rate'),
            $this::PERCENT => Mage::helper('shippinginsurance')->__('Percent rate'),
        );
    }

}
