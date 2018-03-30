<?php

class Robinam_ShippingInsurance_Model_Sales_Order_Total_Invoice_Shippinginsurance extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    /**
     * Collect invoice total
     *
     * @param Mage_Sales_Model_Order_Invoice $invoice
     * @return Robinam_ShippingInsurance_Model_Sales_Order_Total_Invoice_Shippinginsurance
     */
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $order = $invoice->getOrder();

        $shippingInsuranceAmountLeft = $order->getShippinginsuranceAmount() - $order->getShippinginsuranceAmountInvoiced();
        $baseShippingInsuranceAmountLeft = $order->getBaseShippinginsuranceAmount() - $order->getBaseShippinginsuranceAmountInvoiced();

        if (abs($baseShippingInsuranceAmountLeft) < $order->getBaseGrandTotal()) {
            $invoice->setGrandTotal($invoice->getGrandTotal() + $shippingInsuranceAmountLeft);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $baseShippingInsuranceAmountLeft);
        } else {
            $shippingInsuranceAmountLeft = $invoice->getGrandTotal() * -1;
            $baseShippingInsuranceAmountLeft = $invoice->getBaseGrandTotal() * -1;

            $invoice->setGrandTotal(0);
            $invoice->setBaseGrandTotal(0);
        }

        $invoice->setShippinginsuranceAmount($shippingInsuranceAmountLeft);
        $invoice->setBaseShippinginsuranceAmount($baseShippingInsuranceAmountLeft);

        return $this;
    }
}
