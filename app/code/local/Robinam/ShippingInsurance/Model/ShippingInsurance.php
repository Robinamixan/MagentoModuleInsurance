<?php

class Robinam_ShippingInsurance_Model_ShippingInsurance
{
    /** @var false|Robinam_ShippingInsurance_Model_Source_InsuranceRateTypes $shippingInsuranceTypesModel */
    protected $shippingInsuranceTypesModel;

    public function __construct()
    {
        $this->shippingInsuranceTypesModel = Mage::getModel('shippinginsurance/source_insuranceRateTypes');
    }

    /**
     * Retrieve Fee Amount
     *
     * @static
     * @param Mage_Sales_Model_Quote_Address $address
     * @return float
     */
    public function getInsuranceRate(Mage_Sales_Model_Quote_Address $address)
    {
        $subtotal = $address->getQuote()->getTotals()['subtotal']->getValue();

        $shippingMethodsConfigPath = $this->getInsuranceConfigPath($address);

        $insuranceRateTypeConfig = $this->getInsuranceRateTypeByConfigPath($shippingMethodsConfigPath);
        $insuranceRateValueConfig = $this->getInsuranceRateValueByConfigPath($shippingMethodsConfigPath);

        return (float) $this->getInsurancePrice($insuranceRateTypeConfig, $insuranceRateValueConfig, $subtotal);
    }

    public function getInsurancePrice($insuranceRateType, $insuranceRateValue, $subtotal)
    {
        if ($insuranceRateType === (string) $this->shippingInsuranceTypesModel::FIXED) {
            return $insuranceRateValue;
        } else {
            return $subtotal * ((float) $insuranceRateValue / 100);
        }
    }

    /**
     * @param Mage_Sales_Model_Quote_Address $address
     * @return mixed
     */
    public function getInsuranceRateType(Mage_Sales_Model_Quote_Address $address)
    {
        $shippingMethodsConfigPath = $this->getInsuranceConfigPath($address);

        return Mage::getStoreConfig($shippingMethodsConfigPath . 'inshurance_type');
    }

    /**
     * @param $shippingMethodsConfigPath
     * @return mixed
     */
    public function getInsuranceRateTypeByConfigPath($shippingMethodsConfigPath)
    {
        return Mage::getStoreConfig($shippingMethodsConfigPath . 'inshurance_type');
    }

    /**
     * @param $shippingMethodsConfigPath
     * @return mixed
     */
    public function getInsuranceRateValueByConfigPath($shippingMethodsConfigPath)
    {
        return Mage::getStoreConfig($shippingMethodsConfigPath . 'inshurance_rate');
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