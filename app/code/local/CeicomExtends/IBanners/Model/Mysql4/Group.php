<?php
class CeicomExtends_IBanners_Model_Mysql4_Group extends Fishpig_iBanners_Model_Mysql4_Group
{
	public function getBannerCollection(Fishpig_iBanners_Model_Group $group, $includeDisabled = false)
	{
		$bannerCollection = Mage::getResourceModel('ibanners/banner_collection')->addGroupIdFilter($group->getId());
			
		if ($group->getRandomiseBanners()) {
			$bannerCollection->addOrderByRandom();
		} else {	
			$bannerCollection->addOrderBySortOrder();
		}

		if ($group->getValidateBannerDate()) {
			$bannerCollection->addDateFilter();	
		}
		
		if (!$includeDisabled) {
			$bannerCollection->addIsEnabledFilter(1);
		}
		
		return $bannerCollection;
	}
}