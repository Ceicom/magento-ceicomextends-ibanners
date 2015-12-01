<?php
class CeicomExtends_IBanners_Model_Source_Groups
{
	protected $_options;
	
	public function toOptionArray()
    {
        if (!$this->_options) {
        	$groupCollection = Mage::getModel('ibanners/group')->getCollection();

        	foreach ($groupCollection as $group) {
        		$this->_options[] = array(
        			'label' => $group->getTitle(),
        			'value' => $group->getCode()
        		);
        	}
        }
        
        return $this->_options;
    }
}