<?php

class Robinam_ShippingInsurance_TestController extends Mage_Core_Controller_Front_Action
{
    public function myactionAction()
    {
        echo Mage::getStoreConfigFlag('carriers/flatrate/inshurance_enabled');
        echo Mage::getStoreConfig('carriers/flatrate/inshurance_type');
        echo Mage::getStoreConfig('carriers/flatrate/inshurance_rate');
        var_dump($this->getRequest()->getParams());

    }
}