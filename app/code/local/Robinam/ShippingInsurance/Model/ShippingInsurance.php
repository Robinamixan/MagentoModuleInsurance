<?php

class Robinam_ShippingInsurance_Model_ShippingInsurance
{
    /**
     * Retrieve Fee Amount
     *
     * @static
     * @param Mage_Sales_Model_Quote_Address $address
     * @return int
     */
    public static function getShippinginsurance(Mage_Sales_Model_Quote_Address $address)
    {
        $shippingMethod = $address->getShippingMethod();
        $shippingRate = $address->getQuote()->getTotals()['shipping']->getValue();

        $shippingMethodCode = explode("_", $shippingMethod);
        $shippingMethodsConfigPath = 'shippinginsurance/'.$shippingMethodCode[0].'_insurance/';

        $insuranceConfigType = Mage::getStoreConfig($shippingMethodsConfigPath.'inshurance_type');
        $insuranceConfigRate = Mage::getStoreConfig($shippingMethodsConfigPath.'inshurance_rate');

        if ($insuranceConfigType === 'fixed') {
            $insurancePrice = $insuranceConfigRate;
        } else {
            $insurancePrice = $shippingRate * ((double)$insuranceConfigRate / 100);
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
    public static function canApply($address)
    {
        if (!key_exists('shipping', $address->getQuote()->getTotals())) {
            return false;
        }

        $shippingMethod = $address->getShippingMethod();
        $shippingMethodCode = explode("_", $shippingMethod);
        $shippingMethodsConfigPath = 'shippinginsurance/'.$shippingMethodCode[0].'_insurance/';
        $insuranceConfigFlag = Mage::getStoreConfigFlag($shippingMethodsConfigPath.'inshurance_enabled');
        if (!$insuranceConfigFlag) {
            return false;
        }

        $insuranceConfigRate = Mage::getStoreConfig($shippingMethodsConfigPath.'inshurance_rate');
        if (is_null($insuranceConfigRate)) {
            return false;
        }

        if (!Mage::getSingleton('core/session')->getInsuranceCheckboxFlag())
        {
            return false;
        }

        return true;
    }

}