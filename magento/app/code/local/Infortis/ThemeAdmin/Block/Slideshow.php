<?php
class Infortis_ThemeAdmin_Block_Slideshow extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
	public function getImgUrls()
	{
		//Get slides path (relative to 'media'), trim slashes. If path specified: append to 'media' and append slash.
		$slidesUrl = $mediaUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
		$dir = trim(Mage::getStoreConfig('themeadmin/slideshow/directory', Mage::app()->getStore()->getId()), "/");
		if ($dir != '')
			$slidesUrl .= $dir . '/';
		
		//Get filenames separated with commas
		$fileNames = explode(",", Mage::getStoreConfig('themeadmin/slideshow/files', Mage::app()->getStore()->getId()));
		$fileUrls = array();
		foreach ($fileNames as $filename)
		{
			if ( ($trimmedFilename = trim($filename)) != '' )
				$fileUrls[] = $slidesUrl . $trimmedFilename;
		}

		return $fileUrls;
	}
	
	public function getStaticBlockIds()
	{
		$blockIdsString = Mage::getStoreConfig('themeadmin/slideshow/blocks', Mage::app()->getStore()->getId());
		$blockIds = explode(",", str_replace(" ", "", $blockIdsString));
		return $blockIds;
	}
	
	public function getSlideshowConfig()
	{
		$storeId = Mage::app()->getStore()->getId();
		$cfg = array(
			array('label' => 'fx',			'value' => "'" . Mage::getStoreConfig('themeadmin/slideshow/fx', $storeId) . "'"),
            array('label' => 'easing',		'value' => "'" . Mage::getStoreConfig('themeadmin/slideshow/easing', $storeId) . "'"),
			array('label' => 'timeout',		'value' => Mage::getStoreConfig('themeadmin/slideshow/timeout', $storeId)),
            array('label' => 'speedOut',	'value' => Mage::getStoreConfig('themeadmin/slideshow/speed_out', $storeId)),
			array('label' => 'speedIn',		'value' => Mage::getStoreConfig('themeadmin/slideshow/speed_in', $storeId)),
			array('label' => 'sync',		'value' => Mage::getStoreConfig('themeadmin/slideshow/sync', $storeId)),
			array('label' => 'pause',		'value' => Mage::getStoreConfig('themeadmin/slideshow/pause', $storeId)),
			array('label' => 'fit',			'value' => Mage::getStoreConfig('themeadmin/slideshow/fit', $storeId))
        );
		
		//Set height only if it's greater than 0
		if (Mage::getStoreConfig('themeadmin/slideshow/height', $storeId) > 0)
			$cfg[] = array('label' => 'height', 'value' => Mage::getStoreConfig('themeadmin/slideshow/height', $storeId));
		
		return $cfg;
	}
}