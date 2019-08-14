<?php


$installer = $this;

$installer->startSetup();
$installer->run("

DROP TABLE IF EXISTS {$this->getTable('zmags_publication')};

CREATE TABLE {$this->getTable('zmags_publication')} (
  `entity_id` int(8) NOT NULL AUTO_INCREMENT,
  `template_id` int(8) NOT NULL,
  `title` varchar(255) NOT NULL,
  `publication_id` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT 1,
  `custom_theme` varchar(255) DEFAULT NULL,
  `custom_root_template` varchar(255) DEFAULT NULL,
  `publish_from` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('zmags_template')};

CREATE TABLE {$this->getTable('zmags_template')} (
  `entity_id` int(8) NOT NULL AUTO_INCREMENT,
  `template_id` int(8) NOT NULL,
  `status` int(1) DEFAULT 0,
  `template_name` varchar(255),
  `background` varchar(6) DEFAULT 'FFFFFF',
  `text` varchar(6) DEFAULT '333333',
  `heading_colors` varchar(6) DEFAULT '333333',
  `border_width` varchar(6) DEFAULT '333333',
  `border_color` varchar(6) DEFAULT '333333',
  `border_radius` varchar(6) DEFAULT '333333',

  `tn_border_width` varchar(6) DEFAULT '333333',
  `tn_border_color` varchar(6) DEFAULT '333333',
  `tn_border_radius` varchar(6) DEFAULT '333333',

  `description_background` varchar(6) DEFAULT '333333',
  `data_table_odd` varchar(6) DEFAULT '333333',
  `data_table_even` varchar(6) DEFAULT '333333',

  `link` varchar(6) DEFAULT 'FFBB00',
  `hover` varchar(6) DEFAULT 'FF0011',
  `product_name` varchar(6) DEFAULT 'FFBB00',
  `special_price` varchar(6) DEFAULT 'FFBB00',
  `addtocart_bg` varchar(6) DEFAULT '000000',
  `addtocart_font` varchar(6) DEFAULT 'FFFFFF',
  `thumbnail_border` varchar(6) DEFAULT 'CCCCCC',
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`entity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

");


$installer->endSetup();

