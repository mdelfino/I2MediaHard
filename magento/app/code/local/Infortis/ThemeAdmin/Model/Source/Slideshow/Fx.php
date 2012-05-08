<?php

class Infortis_ThemeAdmin_Model_Source_Slideshow_Fx
{
    public function toOptionArray()
    {
        return array(
			array('value' => 'fade',			'label' => Mage::helper('themeadmin')->__('Fade')),
			array('value' => 'zoom',			'label' => Mage::helper('themeadmin')->__('Zoom')),
			array('value' => 'fadeZoom',		'label' => Mage::helper('themeadmin')->__('Fade Zoom')),
			array('value' => 'curtainX',		'label' => Mage::helper('themeadmin')->__('Curtain X')),
			array('value' => 'curtainY',		'label' => Mage::helper('themeadmin')->__('Curtain Y')),
			array('value' => 'blindX',			'label' => Mage::helper('themeadmin')->__('Blind X')),
			array('value' => 'blindY',			'label' => Mage::helper('themeadmin')->__('Blind Y')),
			array('value' => 'blindZ',			'label' => Mage::helper('themeadmin')->__('Blind Z')),
			array('value' => 'growX',			'label' => Mage::helper('themeadmin')->__('Grow X')),
			array('value' => 'growY',			'label' => Mage::helper('themeadmin')->__('Grow Y')),
			array('value' => 'cover',			'label' => Mage::helper('themeadmin')->__('Cover')),
			array('value' => 'uncover',			'label' => Mage::helper('themeadmin')->__('Uncover')),
            array('value' => 'scrollHorz',		'label' => Mage::helper('themeadmin')->__('Scroll Horizontal')),
            array('value' => 'scrollVert',		'label' => Mage::helper('themeadmin')->__('Scroll Vertical')),
			array('value' => 'scrollUp',		'label' => Mage::helper('themeadmin')->__('Scroll Up')),
			array('value' => 'scrollDown',		'label' => Mage::helper('themeadmin')->__('Scroll Down')),
			array('value' => 'scrollLeft',		'label' => Mage::helper('themeadmin')->__('Scroll Left')),
			array('value' => 'scrollRight',		'label' => Mage::helper('themeadmin')->__('Scroll Right')),
			array('value' => 'slideX',			'label' => Mage::helper('themeadmin')->__('Slide X')),
			array('value' => 'slideY',			'label' => Mage::helper('themeadmin')->__('Slide Y')),
			array('value' => 'turnUp',			'label' => Mage::helper('themeadmin')->__('Turn Up')),
			array('value' => 'turnDown',		'label' => Mage::helper('themeadmin')->__('Turn Down')),
			array('value' => 'turnLeft',		'label' => Mage::helper('themeadmin')->__('Turn Left')),
			array('value' => 'turnRight',		'label' => Mage::helper('themeadmin')->__('Turn Right')),
			array('value' => 'wipe',			'label' => Mage::helper('themeadmin')->__('Wipe')),
			array('value' => 'toss',			'label' => Mage::helper('themeadmin')->__('Toss')),
			array('value' => 'shuffle',			'label' => Mage::helper('themeadmin')->__('Shuffle'))
        );
    }
}