<?php

class Robinam_TestModul_TestController extends Mage_Core_Controller_Front_Action
{
    public function myactionAction()
    {
        var_dump($this->getRequest()->getParams());

    }
}