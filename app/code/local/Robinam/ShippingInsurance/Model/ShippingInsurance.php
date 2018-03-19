<?php

class Robinam_ShippingInsurance_Model_ShippingInsurance
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
        $shippingRate = $address->getQuote()->getTotals()['subtotal']->getValue();

        $shippingMethodsConfigPath = $shippingMethodsConfigPath = $this->getInsuranceConfigPath($address);

        $insuranceRateTypeConfig = Mage::getStoreConfig($shippingMethodsConfigPath . 'inshurance_type');
        $insuranceRateValueConfig = Mage::getStoreConfig($shippingMethodsConfigPath . 'inshurance_rate');

        if ($insuranceRateTypeConfig === (string)self::FIXED) {
            $insurancePrice = $insuranceRateValueConfig;
        } else {
            $insurancePrice = $shippingRate * ((float)$insuranceRateValueConfig / 100);
        }

        return $insurancePrice;
    }

    /**
     * @param Mage_Sales_Model_Quote_Address $address
     * @return mixed
     */
    public function getInsuranceType(Mage_Sales_Model_Quote_Address $address)
    {
        $shippingMethodsConfigPath = $this->getInsuranceConfigPath($address);
        return Mage::getStoreConfig($shippingMethodsConfigPath . 'inshurance_type');
    }

    /**
     * @param Mage_Sales_Model_Quote_Address $address
     * @return string
     */
    public function getInsuranceConfigPath(Mage_Sales_Model_Quote_Address $address)
    {
        $shippingMethod = $address->getShippingMethod();
        $shippingMethodCode = explode('_', $shippingMethod);
        return 'shippinginsurance/' . $shippingMethodCode[0] . '_insurance/';
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

        $shippingMethodsConfigPath = $this->getInsuranceConfigPath($address);
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