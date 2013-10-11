<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('slideshow')};
CREATE TABLE {$this->getTable('slideshow')} (
  `slideshow_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',  
  `status` smallint(6) NOT NULL default '0',
  `category_id` int(11) unsigned NOT NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`slideshow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('category')};
CREATE TABLE {$this->getTable('category')} (
  `category_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',`effect` varchar(255) NOT NULL default '',`duration` int(11) NOT NULL default '1800',`pausetime` int(11) NOT NULL default '5000',
  `height` int(11) NOT NULL default '0',
  `width` int(11) NOT NULL default '0',`direct_nav` smallint(6) NOT NULL default '0',`control_nav` smallint(6) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',  
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS `{$this->getTable('category_store')}`;
CREATE TABLE `{$this->getTable('category_store')}` (
  `category_id` int(10) unsigned NOT NULL,
  `store_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`category_id`,`store_id`),
  CONSTRAINT `FK_CATEGORY_STORE_CATEGORY` FOREIGN KEY (`category_id`) REFERENCES `{$this->getTable('category')}` (`category_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `FK_CATEGORY_STORE_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}` (`store_id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");
	



$installer->endSetup(); 