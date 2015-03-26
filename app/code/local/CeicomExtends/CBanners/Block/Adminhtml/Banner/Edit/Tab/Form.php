<?php
class CeicomExtends_CBanners_Block_Adminhtml_Banner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Retrieve Additional Element Types
     *
     * @return array
    */
    protected function _getAdditionalElementTypes()
    {
        return array(
            'image' => Mage::getConfig()->getBlockClassName('ibanners/adminhtml_banner_helper_image')
        );
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('banner_');
        $form->setFieldNameSuffix('banner');

        $this->setForm($form);

        $fieldset = $form->addFieldset('banner_general', array('legend'=> $this->__('General Information')));

        $this->_addElementTypes($fieldset);

        $fieldset->addField('group_id', 'select', array(
            'name'          => 'group_id',
            'label'         => $this->__('Group'),
            'title'         => $this->__('Group'),
            'required'      => true,
            'class'         => 'required-entry',
            'values'        => $this->_getGroups()
        ));

        $fieldset->addField('type', 'select', array(
            'name'          => 'type',
            'label'         => $this->__('Type'),
            'title'         => $this->__('Type'),
            'required'      => true,
            'class'         => 'required-entry',
            'values'        => array( array('label' => 'static', 'value' => 'static'), array('label' => 'timer', 'value' => 'timer') )
        ));

        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $fieldset->addField('start_time', 'date', array(
            'name'   => 'start_time',
            'label'  => $this->__('Start Date'),
            'title'  => $this->__('Start Date'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            // 'input_format' => 'dd/MM/yyyy HH:mm',
            // 'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format'       => 'yyyy-MM-dd HH:mm',
            'time' => true
        ));

        $fieldset->addField('end_time', 'date', array(
            'name'   => 'end_time',
            'label'  => $this->__('End Date'),
            'title'  => $this->__('End Date'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            // 'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format' => 'yyyy-MM-dd HH:mm',
            'time' => true
        ));

        $fieldset->addField('keep_expired_banner', 'select', array(
            'name'          => 'keep_expired_banner',
            'label'         => $this->__('Keep expired banner'),
            'title'         => $this->__('Keep expired banner'),
            'required'      => true,
            'class'         => 'required-entry',
            'values'        => array( array('label' => 'yes', 'value' => 1), array('label' => 'no', 'value' => 0) )
        ));

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => $this->__('Title'),
            'title'     => $this->__('Title'),
            'required'  => true,
            'class'     => 'required-entry',
        ));

        $fieldset->addField('url', 'text', array(
            'name'      => 'url',
            'label'     => $this->__('URL'),
            'title'     => $this->__('URL')
        ));

        $fieldset->addField('url_target', 'text', array(
            'name'      => 'url_target',
            'label'     => $this->__('URL Target'),
            'title'     => $this->__('URL Target'),
            'comment' => $this->__('If empty, current window/tab will be used'),
        ));

        $fieldset->addField('alt_text', 'text', array(
            'name'      => 'alt_text',
            'label'     => $this->__('ALT Text'),
            'title'     => $this->__('ALT Text'),
        ));

        $fieldset->addField('html', 'editor', array(
            'name'      => 'html',
            'label'     => $this->__('HTML'),
            'title'     => $this->__('HTML'),
            'style'     => 'height: 120px; width: 98%;',
        ));

        $fieldset->addField('image', 'image', array(
            'name'      => 'image',
            'label'     => $this->__('Image'),
            'title'     => $this->__('Image'),
            'required'  => true,
            'class'     => 'required-entry',
        ));

        $fieldset->addField('sort_order', 'text', array(
            'name'      => 'sort_order',
            'label'     => $this->__('Sort Order'),
            'title'     => $this->__('Sort Order'),
            'class'     => 'validate-digits',
        ));

        $fieldset->addField('is_enabled', 'select', array(
            'name' => 'is_enabled',
            'title' => $this->__('Enabled'),
            'label' => $this->__('Enabled'),
            'required' => true,
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        if ($banner = Mage::registry('ibanners_banner')) {
            $form->setValues($banner->getData());
        }

        return parent::_prepareForm();
    }

    /**
     * Retrieve an array of all of the stores
     *
     * @return array
     */
    protected function _getGroups()
    {
        $groups = Mage::getResourceModel('ibanners/group_collection');
        $options = array('' => $this->__('-- Please Select --'));

        foreach($groups as $group) {
            $options[$group->getId()] = $group->getTitle();
        }

        return $options;
    }
}
