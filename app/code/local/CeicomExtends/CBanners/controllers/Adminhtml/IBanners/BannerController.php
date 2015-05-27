<?php
require_once(Mage::getModuleDir('controllers','Fishpig_iBanners'). '/Adminhtml/IBanners' .DS.'BannerController.php');

class CeicomExtends_CBanners_Adminhtml_IBanners_BannerController extends Fishpig_iBanners_Adminhtml_iBanners_BannerController
{

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('banner')) {
            $banner = Mage::getModel('ibanners/banner')
                ->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            try {

                $this->_handleImageUpload($banner);
                $this->_handleImageUpload($banner, 'image_mobile');

                $banner->save();
                $this->_getSession()->addSuccess($this->__('Banner was saved'));
            }
            catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                Mage::logException($e);
            }

            if ($this->getRequest()->getParam('back') && $banner->getId()) {
                $this->_redirect('*/*/edit', array('id' => $banner->getId()));
                return;
            }
        }
        else {
            $this->_getSession()->addError($this->__('There was no data to save'));
        }

        $this->_redirect('*/iBanners');
    }
}
