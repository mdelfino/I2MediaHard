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
 * Liste des modes de transitions
 */
class BusinessDecision_Interaktingslider_Model_Source_Mode
{
    public function toOptionArray()
    {
    	return array(
        	array('value' => 'mixte', 
			      'label' => Mage::helper('interaktingslider')->__('Mixte')),
				  
			array('value' => 'auto', 
			      'label' => Mage::helper('interaktingslider')->__('Auto')),
			        
            array('value' => 'manual', 
			      'label' => Mage::helper('interaktingslider')->__('Manual')),
		
        );   
    }
}