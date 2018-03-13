<?php

class Robinam_ShippingInsurance_Model_Observer {

    public function autoMetaDescription(Varien_Event_Observer $observer)
    {
        /* @var $controller Mage_Core_Controller_Varien_Action */
        $controller = $observer->getEvent()->getData('controller_action');

        $data = Mage::app()->getRequest()->getPost('shipping_insurance', '');
        if ($data) {
            Mage::getSingleton('core/session')->setInsuranceCheckboxFlag(true);
        } else {
            Mage::getSingleton('core/session')->setInsuranceCheckboxFlag(false);
        }
    }
}