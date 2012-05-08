<?php

class Infortis_ThemeAdmin_Model_Source_Slideshow_Easing
{
    public function toOptionArray()
    {
        return array(
			//Ease in-out
			array('value' => 'easeInOutSine',	'label' => Mage::helper('themeadmin')->__('easeInOutSine')),
			array('value' => 'easeInOutQuad',	'label' => Mage::helper('themeadmin')->__('easeInOutQuad')),
			array('value' => 'easeInOutCubic',	'label' => Mage::helper('themeadmin')->__('easeInOutCubic')),
			array('value' => 'easeInOutQuart',	'label' => Mage::helper('themeadmin')->__('easeInOutQuart')),
			array('value' => 'easeInOutQuint',	'label' => Mage::helper('themeadmin')->__('easeInOutQuint')),
			array('value' => 'easeInOutExpo',	'label' => Mage::helper('themeadmin')->__('easeInOutExpo')),
			array('value' => 'easeInOutCirc',	'label' => Mage::helper('themeadmin')->__('easeInOutCirc')),
			array('value' => 'easeInOutElastic','label' => Mage::helper('themeadmin')->__('easeInOutElastic')),
			array('value' => 'easeInOutBack',	'label' => Mage::helper('themeadmin')->__('easeInOutBack')),
			array('value' => 'easeInOutBounce',	'label' => Mage::helper('themeadmin')->__('easeInOutBounce')),
			//Ease out
			array('value' => 'easeOutSine',		'label' => Mage::helper('themeadmin')->__('easeOutSine')),
			array('value' => 'easeOutQuad',		'label' => Mage::helper('themeadmin')->__('easeOutQuad')),
			array('value' => 'easeOutCubic',	'label' => Mage::helper('themeadmin')->__('easeOutCubic')),
			array('value' => 'easeOutQuart',	'label' => Mage::helper('themeadmin')->__('easeOutQuart')),
			array('value' => 'easeOutQuint',	'label' => Mage::helper('themeadmin')->__('easeOutQuint')),
			array('value' => 'easeOutExpo',		'label' => Mage::helper('themeadmin')->__('easeOutExpo')),
			array('value' => 'easeOutCirc',		'label' => Mage::helper('themeadmin')->__('easeOutCirc')),
			array('value' => 'easeOutElastic',	'label' => Mage::helper('themeadmin')->__('easeOutElastic')),
			array('value' => 'easeOutBack',		'label' => Mage::helper('themeadmin')->__('easeOutBack')),
			array('value' => 'easeOutBounce',	'label' => Mage::helper('themeadmin')->__('easeOutBounce')),
			//Ease in
			array('value' => 'easeInSine',		'label' => Mage::helper('themeadmin')->__('easeInSine')),
			array('value' => 'easeInQuad',		'label' => Mage::helper('themeadmin')->__('easeInQuad')),
			array('value' => 'easeInCubic',		'label' => Mage::helper('themeadmin')->__('easeInCubic')),
			array('value' => 'easeInQuart',		'label' => Mage::helper('themeadmin')->__('easeInQuart')),
			array('value' => 'easeInQuint',		'label' => Mage::helper('themeadmin')->__('easeInQuint')),
			array('value' => 'easeInExpo',		'label' => Mage::helper('themeadmin')->__('easeInExpo')),
			array('value' => 'easeInCirc',		'label' => Mage::helper('themeadmin')->__('easeInCirc')),
			array('value' => 'easeInElastic',	'label' => Mage::helper('themeadmin')->__('easeInElastic')),
			array('value' => 'easeInBack',		'label' => Mage::helper('themeadmin')->__('easeInBack')),
			array('value' => 'easeInBounce',	'label' => Mage::helper('themeadmin')->__('easeInBounce')),
			//No easing
			array('value' => 'null',			'label' => Mage::helper('themeadmin')->__('Disabled'))
        );
    }
}