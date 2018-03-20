<?php

class Robinam_ShippingInsurance_Block_Onepage_Progress_ShippingInsurance extends Mage_Checkout_Block_Onepage_Progress
{
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
        $shippingInsuranceTypesModel = Mage::getModel('shippinginsurance/source_insuranceRateTypes');
        $insuranceType = $this->getQuote()->getTotals()['shippinginsurance']->getType();
        if ($shippingInsuranceTypesModel::FIXED === (int) $insuranceType) {
            return 'Fixed Rate - ';
        } elseif ($shippingInsuranceTypesModel::PERCENT === (int) $insuranceType) {
            return 'Percent Rate (total price) - ';
        }
        return null;
    }
}
