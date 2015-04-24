<?php
class CeicomExtends_CBanners_Model_Targets extends Mage_Core_Model_Abstract
{

    public function toOptionArray()
    {
        return $this->getTargets();
    }

    public function getTargets()
    {
        $targets = array(
            array( 'label' => 'Open in new window', 'value' => '_blank' ),
            array( 'label' => 'Open in same window', 'value' => '_parent' )
        );

        return $targets;
    }

}
