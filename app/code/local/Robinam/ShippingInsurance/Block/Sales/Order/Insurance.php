<?php

class Robinam_ShippingInsurance_Block_Sales_Order_Insurance extends Mage_Core_Block_Template
{
    /**
     * Get order store object
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * Get totals source object
     *
     * @return Mage_Sales_Model_Order
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * Initialize shippinginsurance totals
     *
     * @return Robinam_ShippingInsurance_Block_Sales_Order_Insurance
     */
    public function initTotals()
    {
        if ((float)$this->getOrder()->getBaseShippinginsuranceAmount()) {
            $source = $this->getSource();
            $value = $source->getShippinginsuranceAmount();

            $this->getParentBlock()->addTotal(new Varien_Object(array(
                'code' => 'shippinginsurance',
                'strong' => false,
                'label' => Mage::helper('shippinginsurance')->__('Shipping Insurance'),
                'value' => $value,
            )));
        }

        return $this;
    }
}
