<?php

class Robinam_ShippingInsurance_Model_Sales_Order_Total_Creditmemo_Shippinginsurance extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    /**
     * Collect credit memo total
     *
     * @param Mage_Sales_Model_Order_Creditmemo $creditmemo
     * @return Robinam_ShippingInsurance_Model_Sales_Order_Total_Creditmemo_Shippinginsurance
     */
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
        $order = $creditmemo->getOrder();

        if ($order->getShippinginsuranceAmountInvoiced() > 0) {
            $shippingInsuranceAmountLeft = $order->getShippinginsuranceAmountInvoiced() - $order->getShippinginsuranceAmountRefunded();
            $baseShippingInsuranceAmountLeft = $order->getBaseShippinginsuranceAmountInvoiced() - $order->getBaseShippinginsuranceAmountRefunded();

            if ($baseShippingInsuranceAmountLeft > 0) {
                $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $shippingInsuranceAmountLeft);
                $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $baseShippingInsuranceAmountLeft);
                $creditmemo->setShippinginsuranceAmount($shippingInsuranceAmountLeft);
                $creditmemo->setBaseShippinginsuranceAmount($baseShippingInsuranceAmountLeft);
            }

        } else {
            $shippingInsuranceAmount = $order->getShippinginsuranceAmountInvoiced();
            $baseShippingInsuranceAmount = $order->getBaseShippinginsuranceAmountInvoiced();

            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $shippingInsuranceAmount);
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $baseShippingInsuranceAmount);
            $creditmemo->setShippinginsuranceAmount($shippingInsuranceAmount);
            $creditmemo->setBaseShippinginsuranceAmount($baseShippingInsuranceAmount);
        }

        return $this;
    }
}
