<?php
class CeicomExtends_IBanners_Block_Banner_Widget_List extends Mage_Core_Block_Template
	implements Mage_Widget_Block_Interface
{
	const DISPLAY_BY_GROUP = 'group';
	const DISPLAY_BY_BANNERS = 'banners';

    protected function _prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->addItem('skin_js', 'ceicomextends/ibanners/js/jquery.countdown.min.js');
        }
        
        return parent::_prepareLayout();
    }

	protected  function _beforeToHtml()
	{
		if ($customTemplate = $this->getCustomTemplate()) {
			$this->setTemplate($customTemplate);
		} else {
			$this->setTemplate('ceicomextends/ibanners/banner/widget/list.phtml');
		}

		$this->setBannerCollection($this->_getBannerCollection());

        return parent::_beforeToHtml();
    }

    protected function _getBannerCollection()
    {
    	switch ($this->getDisplayBy()) {
    		case self::DISPLAY_BY_GROUP:
    			return Mage::getModel('ibanners/group')->loadByCode($this->getGroup())
    				->getBannerCollection();	
    			break;

    		case self::DISPLAY_BY_BANNERS:
    			return Mage::getModel('ibanners/banner')->getCollection()
	    			->addFieldToFilter('banner_id', array('in' => explode(',', $this->getBanners())))
	            	->setOrder('sort_order', 'asc');
    			break;
    		
    		default:
    			return false;
    			break;
    	}
    }
}