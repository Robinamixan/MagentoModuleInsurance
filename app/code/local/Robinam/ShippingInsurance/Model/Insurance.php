<?php

class Robinam_ShippingInsurance_Model_Insurance
{
    const FIXED = 1;
    const PERCENT = 2;

    /**
     * Retrieve Fee Amount
     *
     * @static
     * @param Mage_Sales_Model_Quote_Address $address
     * @return int
     */
    public function getInsuranceRate(Mage_Sales_Model_Quote_Address $address)
    {
        $shippingMethod = $address->getShippingMethod();
        $shippingRate = $address->getQuote()->getTotals()['subtotal']->getValue();

        $shippingMethodCode = explode('_', $shippingMethod);
        $shippingMethodsConfigPath = 'shippinginsurance/' . $shippingMethodCode[0] . '_insurance/';

        $insuranceRateTypeConfig = Mage::getStoreConfig($shippingMethodsConfigPath . 'inshurance_type');
        $insuranceRateValueConfig = Mage::getStoreConfig($shippingMethodsConfigPath . 'inshurance_rate');

        if ($insuranceRateTypeConfig === (string) self::FIXED) {
            $insurancePrice = $insuranceRateValueConfig;
        } else {
            $insurancePrice = $shippingRate * ((float) $insuranceRateValueConfig / 100);
        }

        return $insurancePrice;
    }

    /**
     * Check if shippinginsurance can be apply
     *
     * @static
     * @param Mage_Sales_Model_Quote_Address $address
     * @return bool
     */
    public function canChangeInsuranceAmount($address)
    {
        if (!key_exists('shipping', $address->getQuote()->getTotals())) {
            return false;
        }

        $shippingMethod = $address->getShippingMethod();
        $shippingMethodCode = explode('_', $shippingMethod);
        $shippingMethodsConfigPath = 'shippinginsurance/'.$shippingMethodCode[0].'_insurance/';
        $insuranceConfigFlag = Mage::getStoreConfigFlag($shippingMethodsConfigPath . 'inshurance_enabled');
        if (!$insuranceConfigFlag) {
            return false;
        }

        $insuranceConfigRate = Mage::getStoreConfig($shippingMethodsConfigPath . 'inshurance_rate');
        if (is_null($insuranceConfigRate)) {
            return false;
        }

        if (!Mage::getSingleton('core/session')->getInsuranceCheckboxFlag()) {
            return false;
        }

        return true;
    }

}