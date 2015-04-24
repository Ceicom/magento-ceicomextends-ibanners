<?php
class CeicomExtends_CBanners_Helper_Data extends Mage_Core_Helper_Abstract
{

    private $imagTemplate = "<img id='{{id}}' class='{{class}}' src='/media/ibanners/{{src}}' alt='{{alt}}' data-secondsLeft='{{secondsLeft}}' >";
    private $image;

    public function getTimeLeft($banner)
    {
        return strtotime($banner->getEndTime()) - strtotime( Mage::getModel('core/date')->date('Y-m-d H:i'));
    }

    /*
    * Validate if banner is within the time
    */
    public function isWithinTheTime($banner)
    {
        $startTime = strtotime($banner->getStartTime());
        $endTime = strtotime($banner->getEndTime());
        $actualTime = strtotime(Mage::getModel('core/date')->date('Y-m-d H:i'));

        $betweenTheTime = ( ($banner->getKeepExpiredBanner()) || ($actualTime >= $startTime) && ($actualTime <= $endTime) );
        $noTimePassed = (trim($banner->getStartTime()) == '' && trim($banner->getEndTime()) == '' );
        $justStartTime = ($startTime <= $actualTime && trim($banner->getEndTime()) == '' );

        return ( $betweenTheTime || $noTimePassed || $justStartTime );
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($attributes = null)
    {
        if ( ($attributes != null) && is_array($attributes) ) {
            $this->image = str_replace(array('{{id}}', '{{class}}', '{{src}}', '{{alt}}', '{{secondsLeft}}' ), $attributes, $this->imagTemplate);
        }else {
            $this->image = $this->imagTemplate;
        }
    }

    public function haveLink()
    {
        return true;
    }

    public function groupHtmlWrap($banner, $index)
    {
        $htmlwrap = explode('{{banner}}', $banner->getGroup()->getHtml());
        if ($index == 'start') {
            $htmlwrap = $htmlwrap[0];
        }elseif ($index == 'end') {
            $htmlwrap = $htmlwrap[1];
        }

        return $htmlwrap;
    }

}