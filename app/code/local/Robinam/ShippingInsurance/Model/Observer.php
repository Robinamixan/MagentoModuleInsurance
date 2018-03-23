<?php

class Robinam_ShippingInsurance_Model_Observer {

    public function autoMetaDescription(Varien_Event_Observer $observer)
    {
        $data = Mage::app()->getRequest()->getPost('shipping_insurance', '');

        Mage::getSingleton('core/session')->setInsuranceCheckboxFlag((bool) $data);
    }

    /**
     * Set fee amount invoiced to the order
     *
     * @param Varien_Event_Observer $observer
     * @return Robinam_ShippingInsurance_Model_Observer
     */
    public function invoiceSaveAfter(Varien_Event_Observer $observer)
    {
        $invoice = $observer->getEvent()->getInvoice();

        if ($invoice->getBaseShippinginsuranceAmount()) {
            $order = $invoice->getOrder();
            $order->setShippinginsuranceAmountInvoiced($order->getShippinginsuranceAmountInvoiced() + $invoice->getShippinginsuranceAmount());
            $order->setBaseShippinginsuranceAmountInvoiced($order->getBaseShippinginsuranceAmountInvoiced() + $invoice->getBaseShippinginsuranceAmount());
        }

        return $this;
    }

    /**
     * Set fee amount refunded to the order
     *
     * @param Varien_Event_Observer $observer
     * @return Robinam_ShippingInsurance_Model_Observer
     */
    public function creditmemoSaveAfter(Varien_Event_Observer $observer)
    {
        $creditmemo = $observer->getEvent()->getCreditmemo();

        if ($creditmemo->getShippinginsuranceAmount()) {
            $order = $creditmemo->getOrder();
            $order->setShippinginsuranceAmountRefunded($order->getShippinginsuranceAmountRefunded() + $creditmemo->getShippinginsuranceAmount());
            $order->setBaseShippinginsuranceAmountRefunded($order->getBaseShippinginsuranceAmountRefunded() + $creditmemo->getBaseShippinginsuranceAmount());
        }

        return $this;
    }
}