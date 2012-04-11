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
 * Interaktingslider slide model
 */

class BusinessDecision_Interaktingslider_Model_Slide extends Mage_Core_Model_Abstract
{
 
    
    const CACHE_TAG     = 'admin_slide';
    protected $_cacheTag= 'admin_slide';

    protected function _construct()
    {
        $this->_init('interaktingslider/slide');
        
    }
    
    /**
     * Retourne le contenu du slide avec les URL sur le store view courant
     * 
     * @return contenu du slide avec URL sur store view courant
     * @example url dans content="{{store url='checkout/cart'}}" -> url retournée="http://mage.dev.bd.fr/index.php/checkout/cart/?___store=francais"
     */
    public function getFormatedContent()
    {
    	if(Mage::helper('interaktingslider')->versionUseWysiwig()){
    		$vs_Content = Mage::getModel('widget/template_filter')->filter($this->getContent());
    	}else{
    		$vs_Content = Mage::getModel('core/email_template_filter')->filter($this->getContent());
    	}
    	
		$vs_Content = str_replace(array("\r\n", "\n", "\r"),'',$vs_Content);
		$vs_Content = addslashes($vs_Content);
    	
        return $vs_Content;

    }

    
    /**
     * Retourne la liste des identifiant de Store ou est visible le slide
     *
     * @return array
     */
    public function getAllStoreId(){
    	
    	$va_Stores = $this->getStoreId();
    	if($va_Stores){
    		
    		if($va_Stores[0]!=0){
    			return $va_Stores;
    		}
    		$va_Return = array();
    		foreach (Mage::app()->getStores() as $vo_Store){
    			$va_Return[]=$vo_Store->getId();
    		}
    		return $va_Return;
    	}  	
    	
    }
    
    
    /**
     * Modifie la position du slide dans le store donnée
     *
     * @param integer $pi_StoreId 	l'identifiant du store
     * @param integer $pi_Position	la valeur de la position
     */
    public function setPosition($pi_StoreId,$pi_Position){
    		
    	$va_Position = $this->getData('positions');
    	
    	if($pi_Position){
    		$va_Position[$pi_StoreId] = $pi_Position;
    	}
    	else{
    		unset($va_Position[$pi_StoreId]);
    	}
    	
    	
    	$this->setData('positions',$va_Position);
    	
    }
}
