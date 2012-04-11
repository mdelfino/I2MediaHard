<?php
/**
* Interakting Slider
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@magentocommerce.com and you will be sent a copy immediately.
*
* @category   BusinessDecision
* @package    BusinessDecision_Interaktingslider
* @author     Business & Decision Picardie - contactmagento@interakting.com
* @copyright  Copyright (c) 2009 Business & Decision (http://www.businessdecision.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/ 


/**
 * Liste des effets de transition disponibles
 */
class BusinessDecision_Interaktingslider_Model_Source_Effect
{
    public function toOptionArray()
    {
    	return array(
        	array('value' => 'none', 
			      'label' => Mage::helper('interaktingslider')->__('No Effect')),
				       
            array('value' => 'fade', 
			      'label' => Mage::helper('interaktingslider')->__('Cross Fade')),
			      
			array('value' => 'down', 
			      'label' => Mage::helper('interaktingslider')->__('Blind Down new slide')),
				  
			array('value' => 'up', 
			      'label' => Mage::helper('interaktingslider')->__('Blind Up previous slide')),		      
	       );
        
    }
}