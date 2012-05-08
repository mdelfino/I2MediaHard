<?php

class Infortis_CloudZoom_Block_Product_View_Media extends Mage_Catalog_Block_Product_View_Media
{
    protected function _beforeToHtml()
	{
        if (Mage::getStoreConfig('cloudzoom/general/enabled'))
            $this->setTemplate('infortis/cloudzoom/catalog/product/view/media.phtml');

        return $this;
    }
}
