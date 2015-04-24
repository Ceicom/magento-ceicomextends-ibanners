<?php
class CeicomExtends_CBanners_Block_Banner extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    public $banners = [];

    protected function _toHtml()
    {
        $this->assign('title',$this->getData('title'));
        $this->assign('customCSS',$this->getData('css_class'));

        if(trim($this->getData('custom_template')) != '') {
            $this->setTemplate($this->getData('custom_template'));
        }else {
            $this->setTemplate('ceicomextends/cbanners/banner.phtml');
        }

        $bannersGroupData = Mage::getModel('ibanners/group')->getCollection()
            ->addFieldToFilter('group_id', array('in' => explode(',', $this->getData('banner_groups'))));

        foreach ($bannersGroupData as $group) {
            $bannersIds = Mage::getModel('ibanners/banner')->getCollection()
            ->addFieldToFilter('group_id', array('in' => explode(',', $group->getGroupId())))->getAllIds();
        }

        $banners = explode(',', $this->getData('banners'));

        if(!empty($bannersIds)) {
            $allBannerIds = array_merge($banners, $bannersIds);
        }else {
            $allBannerIds = $banners;
        }

        $bannersData = Mage::getModel('ibanners/banner')->getCollection()
            ->addFieldToFilter('banner_id', array('in' => $allBannerIds));

        $this->setBannerCollection($bannersData);

        return parent::_toHtml();
    }

    public function getBannerHtml($banner)
    {
        $helper = Mage::helper('cbanners');
        $html = '';

        if($banner->getType() == 'timer') {
            $cssClass = "banner-timer {$banner->getCssClass()}";
            $id = "{$banner->getType()}-{$banner->getId()}";
        }else {
            $cssClass = $banner->getCssClass();
            $id = $banner->getId();
        }

        $helper->setImage( array( $id, $cssClass, "{$banner->getImage()}", $banner->getAltText(), $helper->getTimeLeft($banner) ) );

        if (trim($banner->getHtml()) != ''  ) {
            $html = str_replace('{{image}}', $helper->getImage(), $banner->getHtml());
        }else {
            $html = $helper->getImage();
        }

        return $html;
    }

    public function getBannerCollection()
    {
        return $this->banners;
    }

    protected function setBannerCollection($data)
    {
        $this->banners = $data;
    }

}
