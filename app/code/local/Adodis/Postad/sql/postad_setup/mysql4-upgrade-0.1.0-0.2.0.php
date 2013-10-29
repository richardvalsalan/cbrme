<?php

$installer = $this;

$installer->startSetup();

$installer->run("
	ALTER TABLE slideshow add COLUMN product_sku varchar(255) NULL;
");

$installer->endSetup();