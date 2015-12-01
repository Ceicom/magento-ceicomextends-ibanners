<?php
$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn(
	$installer->getTable('ibanners_banner'),
	'wrapper_class',
	array(
		'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
		'length'   => 50,
		'nullable' => true,
		'comment'  => 'Wrapper Class'
	)	
);

$installer->getConnection()->addColumn(
	$installer->getTable('ibanners_banner'),
	'start_date',
	array(
		'type'     => Varien_Db_Ddl_Table::TYPE_DATETIME,
		'nullable' => true,
		'comment'  => 'Start Date'
	)	
);

$installer->getConnection()->addColumn(
	$installer->getTable('ibanners_banner'),
	'end_date',
	array(
		'type'     => Varien_Db_Ddl_Table::TYPE_DATETIME,
		'nullable' => true,
		'comment'  => 'End Date'
	)	
);

$installer->getConnection()->addColumn(
	$installer->getTable('ibanners_group'),
	'validate_banner_date',
	array(
		'type'     => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
		'default'  => 1,
		'nullable' => false,
		'comment'  => 'Validate Banner Date'
	)
);

$installer->endSetup();