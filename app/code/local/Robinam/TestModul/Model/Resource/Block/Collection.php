<?php

class Robinam_TestModul_Model_Resource_Block_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('siteblocks/block');
    }
}