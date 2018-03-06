<?php

class Robinam_TestModul_Model_Resource_Block  extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('siteblocks/block', 'block_id');
    }
}