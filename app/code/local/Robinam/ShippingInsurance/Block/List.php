<?php

class Robinam_ShippingInsurance_Block_List extends Mage_Checkout_Block_Onepage_Shipping_Method_Available
{
    public function getShipping()
    {
        $temp = $this->getShippingRates();

        //var_dump($temp);

        $temp2 = $this->getQuote()->getShippingAddress()->getData();

        var_dump($temp2);
        ;
    }
}