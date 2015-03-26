<?php
class CeicomExtends_CBanners_Model_Groups extends Mage_Core_Model_Abstract
{

    public function toOptionArray()
    {
        return $this->getGroups();
    }

    public function getGroups()
    {
        $bannerGroups = Mage::getModel('ibanners/group')->getCollection();

        foreach ($bannerGroups as $bannerGroup) {
            $groups[] = array(
                'label' => $bannerGroup->getTitle(),
                'value' => $bannerGroup->getGroupId()
            );
        }

        return $groups;
    }

}
