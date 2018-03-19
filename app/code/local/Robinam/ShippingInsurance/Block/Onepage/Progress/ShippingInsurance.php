<?php

class Robinam_ShippingInsurance_Block_Onepage_Progress_ShippingInsurance extends Mage_Checkout_Block_Onepage_Progress
{
    const FIXED = 1;
    const PERCENT = 2;

    public function isEnabledInsurance()
    {
        return Mage::getSingleton('core/session')->getInsuranceCheckboxFlag();
    }

    public function getInsuranceRate()
    {
        return '$' . $this->getQuote()->getTotals()['shippinginsurance']->getValue();
    }

    public function getInsuranceType()
    {
        $insuranceType = $this->getQuote()->getTotals()['shippinginsurance']->getType();
        if (self::FIXED === (int) $insuranceType) {
            return 'Fixed Rate - ';
        } elseif (self::PERCENT === (int) $insuranceType) {
            return 'Percent Rate (total price) - ';
        }
        return null;
    }
}