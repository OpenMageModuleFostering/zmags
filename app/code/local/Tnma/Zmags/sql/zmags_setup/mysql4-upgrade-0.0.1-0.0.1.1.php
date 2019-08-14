<?php


$installer = $this;

$installer->startSetup();
$installer->run("
ALTER TABLE {$this->getTable('zmags_publication')} ADD COLUMN `height` INT NULL DEFAULT 800  AFTER `status` ;
");


$installer->endSetup();

