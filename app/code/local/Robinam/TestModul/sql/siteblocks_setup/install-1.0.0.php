<?php

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();
$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('siteblocks/block')}` (
  `block_id`     INT(11)      NOT NULL AUTO_INCREMENT,
  `title`        VARCHAR(500) NOT NULL,
  `content`      TEXT         NOT NULL,
  `block_status` TINYINT(4)   NOT NULL,
  `created_at`   DATETIME     NOT NULL,
  PRIMARY KEY (`block_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = latin1
  AUTO_INCREMENT = 1;
");
$installer->endSetup();