<?php

class Infortis_ThemeAdmin_Model_Source_Design_Navbar_Level2Link
{
    public function toOptionArray()
    {
        return array(
			array('value' => 'default',			'label' => Mage::helper('themeadmin')->__('Default')),
			array('value' => 'lgray-red',		'label' => Mage::helper('themeadmin')->__('Light Gray - Red')),
			array('value' => 'lgray-gray',		'label' => Mage::helper('themeadmin')->__('Light Gray - Gray')),
			array('value' => 'lblue-blue',		'label' => Mage::helper('themeadmin')->__('Light Blue - Blue'))
        );
    }
}