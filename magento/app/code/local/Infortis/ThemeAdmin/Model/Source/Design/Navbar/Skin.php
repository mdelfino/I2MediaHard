<?php

class Infortis_ThemeAdmin_Model_Source_Design_Navbar_Skin
{
    public function toOptionArray()
    {
        return array(
			array('value' => 'default',			'label' => Mage::helper('themeadmin')->__('Default')),
			array('value' => 'gray-l',			'label' => Mage::helper('themeadmin')->__('Gray - Light')),
			array('value' => 'gray-d',			'label' => Mage::helper('themeadmin')->__('Gray - Dark')),
			array('value' => 'green-pea',		'label' => Mage::helper('themeadmin')->__('Green Pea')),
			array('value' => 'green-pea-d',		'label' => Mage::helper('themeadmin')->__('Green Pea - Dark')),
			array('value' => 'blue',			'label' => Mage::helper('themeadmin')->__('Blue')),
			array('value' => 'navy',			'label' => Mage::helper('themeadmin')->__('Navy')),
			array('value' => 'orange',			'label' => Mage::helper('themeadmin')->__('Orange')),
			array('value' => 'crimson',			'label' => Mage::helper('themeadmin')->__('Crimson')),
			array('value' => 'red',				'label' => Mage::helper('themeadmin')->__('Red')),
			array('value' => 'red-saturated',	'label' => Mage::helper('themeadmin')->__('Saturated Red')),
			array('value' => 'red-d',			'label' => Mage::helper('themeadmin')->__('Red - Dark'))
			
        );
    }
}