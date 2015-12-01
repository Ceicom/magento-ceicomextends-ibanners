<?php
class CeicomExtends_IBanners_Model_Source_Banners
{
	protected $_options;
	
	public function toOptionArray()
    {
        if (!$this->_options) {
        	$bannerCollection = Mage::getModel('ibanners/banner')->getCollection();

        	foreach ($bannerCollection as $banner) {
        		$this->_options[] = array(
        			'label' => $banner->getTitle(),
        			'value' => $banner->getId()
        		);
        	}
        }
        
        return $this->_options;
    }
}