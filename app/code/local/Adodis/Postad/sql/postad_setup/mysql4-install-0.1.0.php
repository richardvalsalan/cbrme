<?php

$installer = $this;

$installer->startSetup();

$installer->run("
	ALTER TABLE `{$installer->getTable('sales/order')}` ADD `enable_ad` VARCHAR(255) NOT NULL DEFAULT 'Yes';
    ALTER TABLE `{$installer->getTable('sales/order_grid')}` ADD `enable_ad` VARCHAR(255) NOT NULL DEFAULT 'Yes';
");

$installer->endSetup();
