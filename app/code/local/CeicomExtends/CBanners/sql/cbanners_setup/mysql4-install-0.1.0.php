<?php
$this->startSetup();

$this->getConnection()->addColumn($this->getTable('ibanners_banner'), 'start_time', "varchar(255) NOT NULL default ''");
$this->getConnection()->addColumn($this->getTable('ibanners_banner'), 'end_time', "varchar(255) NOT NULL default ''");
$this->getConnection()->addColumn($this->getTable('ibanners_banner'), 'css_class', "varchar(255) NOT NULL default ''");
$this->getConnection()->addColumn($this->getTable('ibanners_banner'), 'url_target', "varchar(255) NOT NULL default ''");
$this->getConnection()->addColumn($this->getTable('ibanners_banner'), 'type', "varchar(255) NOT NULL default ''");
$this->getConnection()->addColumn($this->getTable('ibanners_banner'), 'keep_expired_banner', "varchar(255) NOT NULL default ''");

$this->getConnection()->addColumn($this->getTable('ibanners_group'), 'html', " TEXT NOT NULL default ''");

$this->endSetup();
