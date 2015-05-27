<?php
$this->startSetup();

$this->getConnection()->addColumn($this->getTable('ibanners_banner'), 'image_mobile', "varchar(255) NOT NULL default ''");

$this->endSetup();
