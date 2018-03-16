<?php

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

$installer->run("
    ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `shippinginsurance_amount` DECIMAL( 10, 2 ) NOT NULL;
    ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `base_shippinginsurance_amount` DECIMAL( 10, 2 ) NOT NULL;
    ALTER TABLE  `".$this->getTable('sales/order')."` ADD  `shippinginsurance_amount` DECIMAL( 10, 2 ) NOT NULL;
    ALTER TABLE  `".$this->getTable('sales/order')."` ADD  `base_shippinginsurance_amount` DECIMAL( 10, 2 ) NOT NULL;
");

$installer->endSetup();