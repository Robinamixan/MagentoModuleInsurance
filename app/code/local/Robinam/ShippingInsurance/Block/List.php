<?php

class Robinam_ShippingInsurance_Block_List extends Mage_Checkout_Block_Onepage_Shipping_Method_Available
{
    public function getShipping()
    {
        $temp = $this->getAddressShippingMethod();

        //var_dump($temp);

//        $temp2 = $this->getQuote()->getTotals();
//        $shippingValue = $temp2['shipping']->getData()['value'];

//        var_dump($temp2['shipping']);


        return '';
    }
}