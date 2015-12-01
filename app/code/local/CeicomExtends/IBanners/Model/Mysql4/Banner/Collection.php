<?php
class CeicomExtends_IBanners_Model_Mysql4_Banner_Collection extends Fishpig_iBanners_Model_Mysql4_Banner_Collection
{
	public function addDateFilter()
	{
		$this->addFieldToFilter('start_date', array(
	        array('to' => Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s')),
	        array('start_date', 'null' => '')
        ));

		$this->addFieldToFilter('end_date', array(
	        array('from' => Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s')),
	        array('end_date', 'null' => '')
        ));

        return $this;
	}
}