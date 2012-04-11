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

class BusinessDecision_Interaktingslider_Model_Source_Skin
{
    public function toOptionArray()
    {
    	$va_Skins = array();
    	
    	foreach ($this->getSkins() as $vSkin){
    		$va_Skins[] = array('value' => $vSkin, 
			      			'label' => $this->getInfos($vSkin));
    	}		
		
		return $va_Skins;
    }
    
    
    private function getPath(){
    	return Mage::getBaseDir('skin').DS.'interaktingslider';
    }
    /**
     * Parcours le répertoire des skins
     *
     */
    private function getSkins(){
    			
    	$va_Skins = array();
		
		if ( is_dir($this->getPath()) ) {
			$list = scandir($this->getPath());
			foreach ($list as $number => $filename){			
				if ( $filename !== '.' && $filename !== '..' && is_dir($this->getPath().'/'.$filename) ){		
            		
            			$va_Skins[] = $filename;
				}
			}
		}
		
		return $va_Skins;
    }
    
    
     /**
     * Récupére les infos sur le skin
     * Taille
     *
     */
    private function getInfos($pSkin){
    	
    	$vs_File = $this->getPath().'/'.$pSkin.'/info.txt';
    	
    	$vs_Infos = $pSkin;
    	
    	if(file_exists($vs_File)){
// 
//    		$va_Lignes = file($vs_File);
//    		$vs_Infos .=' &nbsp;&nbsp; (';
//    		foreach ($va_Lignes as $vs_Ligne){
//    			$va_Infos = explode(':',$vs_Ligne);
//    			$vs_Infos .= ' '.Mage::helper('interaktingslider')->__($va_Infos[0]);
//    			$vs_Infos .= ':'.$va_Infos[1];
//    		}
//    		$vs_Infos .=' )';
    	}
    	
    	return $vs_Infos;
    	
    }
    
 
}