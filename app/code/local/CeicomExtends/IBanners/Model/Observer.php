<?php
class CeicomExtends_IBanners_Model_Observer
{
	public function adminhtmlBlockHtmlBefore($observer)
	{
		$block = $observer->getEvent()->getBlock();

		switch ($block->getType()) {
			case 'ibanners/adminhtml_banner_edit_tab_form':
				$this->_addBannerExtraFields($block->getForm());
				break;

			case 'ibanners/adminhtml_group_edit_tab_form':
				$this->_addGroupExtraFields($block->getForm());
				break;
			
			default:
				break;
		}
	}

	protected function _addBannerExtraFields($form)
	{
		$fieldset = $form->getElement('banner_general');
		$locale = Mage::app()->getLocale();
		$outputFormat = $locale->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

		$fieldset->addField('wrapper_class', 'text', array(
			'name'  => 'wrapper_class',
			'label' => $this->_getHelper()->__('Wrapper Class'),
			'title' => $this->_getHelper()->__('Wrapper Class'),
			'note'  => $this->_getHelper()->__('It depends on your template file')
		));

		$fieldset->addField('start_date', 'date', array(
            'name'   => 'start_date',
            'time'   => true,
            'format' => $outputFormat,
            'label'  => $this->_getHelper()->__('Start Date'),
            'title'  => $this->_getHelper()->__('Start Date'),
            'image'  => $this->_getSkinUrl('images/grid-cal.gif')
        ));

        $fieldset->addField('end_date', 'date', array(
            'name'   => 'end_date',
            'time'   => true,
            'format' => $outputFormat,
            'label'  => $this->_getHelper()->__('End Date'),
            'title'  => $this->_getHelper()->__('End Date'),
            'image'  => $this->_getSkinUrl('images/grid-cal.gif')
        ));		

		if ($banner = Mage::registry('ibanners_banner')) {
			$form->setValues($banner->getData());

			if ($bannerStartDate = $banner->getStartDate()) {
				$form->getElement('start_date')->setValue($locale->date($bannerStartDate, Varien_Date::DATETIME_INTERNAL_FORMAT));
			}

			if ($bannerEndDate = $banner->getEndDate()) {
				$form->getElement('end_date')->setValue($locale->date($bannerEndDate, Varien_Date::DATETIME_INTERNAL_FORMAT));
			}
		}
	}

	protected function _addGroupExtraFields($form)
	{
		$fieldset = $form->getElement('group_general');

		$fieldset->addField('validate_banner_date', 'select', array(
			'name'   => 'validate_banner_date',
			'label'  => $this->_getHelper()->__('Validate Banner Date'),
			'title'  => $this->_getHelper()->__('Validate Banner Date'),
			'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
		));

		if ($group = Mage::registry('ibanners_group')) {
			$form->setValues($group->getData());
		}
	}

	public function bannerSaveBefore()
	{
		if ($data = Mage::app()->getRequest()->getPost('banner')) {
			if (!empty($data['start_date'])) {
				$data['start_date'] = $this->_gmtDate($data['start_date']);
			}

			if (!empty($data['end_date'])) {
				$data['end_date'] = $this->_gmtDate($data['end_date']);
			}

			Mage::app()->getRequest()->setPost('banner', $data);
		}
	}

	protected function _gmtDate($date, $format = Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
	{
		$locale = Mage::app()->getLocale();
        $format = $locale->getDateTimeFormat($format);
        $time = $locale->date($date, $format)->getTimestamp();
        
        return Mage::getModel('core/date')->gmtDate(null, $time);
	}

	protected function _getHelper()
	{
		return Mage::helper('ceicomextends_ibanners');
	}

	protected function _getSkinUrl($file = null, $params = array())
	{
		return Mage::getModel('core/design_package')->getSkinUrl($file, $params);
	}
}