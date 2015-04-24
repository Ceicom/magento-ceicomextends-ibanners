<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class CeicomExtends_CBanners_Block_Adminhtml_Group_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('group_');
        $form->setFieldNameSuffix('group');

        $this->setForm($form);

        $fieldset = $form->addFieldset('group_general', array('legend'=> $this->__('General Information')));

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => $this->__('Title'),
            'title'     => $this->__('Title'),
            'required'  => true,
            'class'     => 'required-entry',
        ));

        $fieldset->addField('code', 'text', array(
            'name'      => 'code',
            'label'     => $this->__('Code'),
            'title'     => $this->__('Code'),
            'note'      => $this->__('This is a unique identifier that is used to inject the banner group via XML'),
            'required'  => true,
            'class'     => 'required-entry validate-code',
        ));

        $fieldset->addField('randomise_banners', 'select', array(
            'name' => 'randomise_banners',
            'comment' => $this->__('This is for groups with more than 1 banner in'),
            'title' => $this->__('Randomise Banner Position'),
            'label' => $this->__('Randomise Banner Position'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $fieldset->addField('is_enabled', 'select', array(
            'name' => 'is_enabled',
            'title' => $this->__('Enabled'),
            'label' => $this->__('Enabled'),
            'required' => true,
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $fieldset->addField('store_id', 'select', array(
            'name'      => 'store_id',
            'label'     => $this->__('Store'),
            'title'     => $this->__('Store'),
            'required'  => true,
            'class'     => 'required-entry',
            'values'    => $this->_getStores()
        ));

        $fieldset->addField('html', 'editor', array(
            'name'      => 'html',
            'label'     => $this->__('HTML'),
            'title'     => $this->__('HTML'),
            'style'     => 'height: 120px; width: 98%;',
            'note' => $this->__('use {{banner}} for define the banner location.'),
        ));

        $fieldset = $form->addFieldset('group_settings', array('legend'=> $this->__('Carousel Settings')));

        $fieldset->addField('carousel_animate', 'select', array(
            'name' => 'carousel_animate',
            'title' => $this->__('Enable Animation'),
            'label' => $this->__('Enable Animation'),
            'required' => true,
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));


        $fieldset->addField('carousel_duration', 'text', array(
            'name' => 'carousel_duration',
            'title' => $this->__('Animation Duration'),
            'label' => $this->__('Animation Duration'),
            'class' => 'validate-greater-than-zero',
        ));

        $fieldset->addField('carousel_auto', 'select', array(
            'name' => 'carousel_auto',
            'title' => $this->__('Auto-Start'),
            'label' => $this->__('Auto-Start'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $fieldset->addField('carousel_frequency', 'text', array(
            'name' => 'carousel_frequency',
            'title' => $this->__('Animation Frequency'),
            'label' => $this->__('Animation Frequency'),
            'class' => 'validate-greater-than-zero',
        ));

        $fieldset->addField('carousel_visible_slides', 'text', array(
            'name' => 'carousel_visible_slides',
            'title' => $this->__('Visible Slides'),
            'label' => $this->__('Visible Slides'),
            'class' => 'validate-greater-than-zero',
        ));

        $fieldset->addField('carousel_effect', 'select', array(
            'name' => 'carousel_effect',
            'title' => $this->__('Effect'),
            'label' => $this->__('Effect'),
            'values' => Mage::getModel('ibanners/system_config_source_carousel_effect')->toOptionArray(),
        ));

        $fieldset->addField('carousel_transition', 'select', array(
            'name' => 'carousel_transition',
            'title' => $this->__('Transition'),
            'label' => $this->__('Transition'),
            'values' => Mage::getModel('ibanners/system_config_source_carousel_transition')->toOptionArray(),
        ));

        $fieldset = $form->addFieldset('group_controls', array('legend'=> $this->__('Controls')));

        $fieldset->addField('controls_position', 'select', array(
            'name' => 'controls_position',
            'title' => $this->__('Position'),
            'label' => $this->__('Position'),
            'values' => Mage::getModel('ibanners/system_config_source_controls_position')->toOptionArray(),
        ));

        $fieldset->addField('controls_overlap', 'select', array(
            'name' => 'controls_overlap',
            'title' => $this->__('Overlap'),
            'label' => $this->__('Overlap'),
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
            'note' => $this->__('If yes, the controls will be positioned half inside the banner and half outside.'),
        ));

        if ($group = Mage::registry('ibanners_group')) {
            $form->setValues($group->getData());
        }
        else {
            $form->setValues(Mage::getModel('ibanners/group')->getAnimationData());
        }

        return parent::_prepareForm();
    }

    /**
     * Retrieve an array of all of the stores
     *
     * @return array
     */
    protected function _getStores()
    {
        $stores = Mage::getResourceModel('core/store_collection');
        $options = array(0 => $this->__('Global'));

        foreach($stores as $store) {
            $options[$store->getId()] = $store->getWebsite()->getName() . ': ' . $store->getName();
        }

        return $options;
    }
}
