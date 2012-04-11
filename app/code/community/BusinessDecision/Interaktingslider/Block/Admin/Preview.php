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
 * Previsualisateur de slide
 */

Class BusinessDecision_Interaktingslider_Block_Admin_Preview extends BusinessDecision_Interaktingslider_Block_Interaktingslider {
	
	protected $_slides = array();
	
	/**
     * Surcharge du Render block pour le preview
     *
     * @return string
     */
    public function renderView()
    {
    	$vs_adminArea = Mage::getDesign()->getArea();
   		Mage::getDesign()->setArea(Mage_Core_Model_Design_Package::DEFAULT_AREA);	
    	$html = parent::renderView();
    	Mage::getDesign()->setArea($vs_adminArea);
    	
        return $html;
    }
	
	/**
	 * Ajoute le slide à prévisualiser
	 *
	 * @param BusinessDecision_Interaktingslider_Model_Slide $vo_Preview slide à prévisualiser
	 */
	public function addSlide(BusinessDecision_Interaktingslider_Model_Slide $vo_Preview){
		$this->_slides[]=$vo_Preview;
	}
	
	/**
	 * Retourne la liste de tous les slides
	 *
	 * @return Tableau de slides
	 */
	public function getSlides(){
		return $this->_slides;
	}
	

	/*protected function _toHtml()
	{
					// Code Js pour redimentionner la popup
			$sResize = '<script>
			
						
							var frameWidth = document.getElementById("frame").offsetWidth;
							var frameHeight = document.getElementById("frame").offsetHeight;
							
							if(window.innerWidth){
								window.innerWidth = frameWidth+20;
								window.innerHeight = frameHeight+20;
							}
							else{
							
								winW = document.body.clientWidth;
								winH = document.body.clientHeight;
								
								deltaW = -1*(winW-frameWidth);
								deltaH = -1*(winH-frameHeight);
								
								window.resizeBy(deltaW+20,deltaH+20)
													
							}
							
				
							
							winLeft = (screen.width-frameWidth)/2;
							winTop = (screen.height-frameHeight)/2;
							window.moveTo(winLeft,winTop);
							window.focus();

						
						
			</script>';
			
			return parent::_toHtml().$sResize;
	}*/
}