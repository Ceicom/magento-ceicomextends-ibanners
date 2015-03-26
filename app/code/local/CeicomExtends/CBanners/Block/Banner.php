<?php
class CeicomExtends_CBanners_Block_Banner extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    public $banners = [];

    protected function _toHtml()
    {
        $this->assign('title',$this->getData('title'));
        $this->assign('customCSS',$this->getData('css_class'));

        $this->setTemplate('ceicomextends/cbanners/banner.phtml');

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

    public function getBannerCollection()
    {
        return $this->banners;
    }

    protected function setBannerCollection($data)
    {
        $this->banners = $data;
    }

    public function displayHtml($banner)
    {
        if (!empty($banner->getHtml())) {
            $html = str_replace("{{image}}","<img src='/media/ibanners/{$banner->getImage()}' width='100%'>",$banner->getHtml());
        }else {
            $html = "<img src='/media/ibanners/{$banner->getImage()}' width='100%'>";
        }

        return $html;
    }

    public function getTimeLeft($banner)
    {
        return strtotime($banner->getEndTime()) - strtotime( Mage::getModel('core/date')->date('Y-m-d H:i'));
    }

    public function validBanner($banner)
    {
        $start_ts = strtotime($banner->getStartTime());
        $end_ts = strtotime($banner->getEndTime());
        $user_ts = strtotime(Mage::getModel('core/date')->date('Y-m-d H:i'));

        return ( ($banner->getKeepExpiredBanner()) || ($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }

}
