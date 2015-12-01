<?php
class CeicomExtends_IBanners_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getLocaleDate($date)
	{
		return Mage::app()->getLocale()->date($date);
	}
}