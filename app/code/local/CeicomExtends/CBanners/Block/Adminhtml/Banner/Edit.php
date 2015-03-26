<?php
class CeicomExtends_CBanners_Block_Adminhtml_Banner_Edit  extends Fishpig_iBanners_Block_Adminhtml_Banner_Edit
{
    public function __construct()
    {
        parent::__construct();

        $this->_controller = 'adminhtml_banner';
        $this->_blockGroup = 'ibanners';
        $this->_headerText = $this->_getHeaderText();

        $this->_addButton('save_and_edit_button', array(
            'label'     => Mage::helper('catalog')->__('Save and Continue Edit'),
            'onclick'   => 'editForm.submit(\''.$this->getSaveAndContinueUrl().'\')',
            'class' => 'save'
        ));
    }

    /**
     * Retrieve the URL used for the save and continue link
     * This is the same URL with the back parameter added
     *
     * @return string
     */
    public function getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
        ));
    }

    /**
     * Retrieve the header text
     * If splash page exists, use name
     *
     * @return string
     */
    protected function _getHeaderText()
    {
        if ($banner = Mage::registry('ibanners_banner')) {
            if ($displayName = $banner->getTitle()) {
                return $displayName;
            }
        }

        return $this->__('Edit Banner');
    }
}
