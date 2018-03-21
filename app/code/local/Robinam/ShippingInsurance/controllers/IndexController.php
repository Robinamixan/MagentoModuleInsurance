<?php

class Robinam_ShippingInsurance_IndexController extends Mage_Core_Controller_Front_Action
{
    public function ajaxAction()
    {
        $request = Mage::app()->getRequest();

        /** @var false|Robinam_ShippingInsurance_Model_ShippingInsurance $insuranceModel */
        $insuranceModel = Mage::getModel('shippinginsurance/shippingInsurance');

        $shippingMethodCode = explode('_', $request->getPost('shipping_code', ''));
        $subtotal = $request->getPost('subtotal', '');

        $shippingMethodsConfigPath = 'shippinginsurance/' . $shippingMethodCode[0] . '_insurance/';
        $insuranceRateTypeConfig = $insuranceModel->getInsuranceRateTypeByConfigPath($shippingMethodsConfigPath);
        $insuranceRateValueConfig = $insuranceModel->getInsuranceRateValueByConfigPath($shippingMethodsConfigPath);

        $insurancePrice = $insuranceModel->getInsurancePrice($insuranceRateTypeConfig, $insuranceRateValueConfig, $subtotal);

        $isAjax = $request->isAjax();
        if ($isAjax) {
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(['outputValue' => $insurancePrice]));
        }
    }

}