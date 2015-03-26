<?php
class CeicomExtends_CBanners_Model_Banners extends Mage_Core_Model_Abstract
{

    public function toOptionArray()
    {
        return $this->getBanners();
    }

    public function getBanners()
    {
        $bannersData = Mage::getModel('ibanners/banner')->getCollection();

        foreach ($bannersData as $banner) {
            $banners[] = array(
                'label' => $banner->getTitle(),
                'value' => $banner->getBannerId()
            );
        }

        return $banners;
    }

}
