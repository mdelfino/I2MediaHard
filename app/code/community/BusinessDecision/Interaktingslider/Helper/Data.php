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
 * Interaktingslider Data Helper
 */

class BusinessDecision_Interaktingslider_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Retourne vrai si cette version utilise le Wysiwig Magento
	 *
	 * @return boolean
	 */
	public function versionUseWysiwig(){
		$info = explode('.',Mage::getVersion());
    	
    	if($info[0]>1){
    		return true;
    	}
    	
    	if($info[1]>3){
    		return true;
    	}
    	
    	return false;
	}
	
	/**
	 * Retourne vrai si cette version utilise les redéfinitions de titre en Admin
	 *
	 * @return boolean
	 */
    public function versionUseAdminTitle(){
    	
    	$info = explode('.',Mage::getVersion());
    	
    	if($info[0]>1){
    		return true;
    	}
    	
    	if($info[1]>3){
    		return true;
    	}
    	
    	return false;
    }
}
