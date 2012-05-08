<?php

class Infortis_CloudZoom_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getOptionValue($optionString)
    {
        return Mage::getStoreConfig('cloudzoom/general/' . $optionString);
    }
}
