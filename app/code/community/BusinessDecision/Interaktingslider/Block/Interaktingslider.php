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
* @package    BusinessDecision_InteraktingSlider
* @author     Business & Decision Picardie - contactmagento@interakting.com
* @copyright  Copyright (c) 2009 Business & Decision (http://www.businessdecision.com)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/ 

Class BusinessDecision_Interaktingslider_Block_Interaktingslider extends Mage_Core_Block_Template {
	
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('interaktingslider/slider.phtml');        
    }
	
	/**
	 * Retourne le model
	 *
	 * @return BusinessDecision_Interaktingslider_Model_Interaktingslider
	 */
	public function getModel(){
		return Mage::getModel('interaktingslider/interaktingslider');
	}

	
	/**
	 * Retourne la collection des slides
	 *
	 * @return array
	 */	
	public function getSlides(){
		return $this->getModel()->getSlides();
	}
	
	/**
	 * Code d'ajout du fichier Js de l'Interakting Slider
	 *
	 * @return code HTML
	 */
	public function addJs(){
		return '<script type="text/javascript" src="'.Mage::getBaseUrl('js').'interaktingslider/interaktingslider.js"></script>';

	}

	/**
	 * Chargement et lancement du JS de l'Interakting slider
	 *
	 * @return unknown
	 */
	public function startJs(){

  
		$vs_Js = "
		
			var interaktingslider = new InteraktingSlider(); 
			
			interaktingslider.setDelay(".$this->getModel()->getDelay().");
			interaktingslider.setTransition('".$this->getModel()->getTransition()."');
			interaktingslider.setSpeed(".$this->getModel()->getSpeed().");		
			interaktingslider.setMode('".$this->getModel()->getMode()."');
			
		";

		$va_Slides = $this->getSlides();

		if($va_Slides){
			foreach ($va_Slides as $vo_Slide){
				$vs_Js .= 'interaktingslider.addSlide("'.$vo_Slide->getFormatedContent().'"); ';
			}
		}
		$vs_Js .= "
			interaktingslider.show(); 		
		";


		return $vs_Js;

	}

	

	/**
	 * Retourne le style d'affichage défini pour le skin courant
	 *
	 * @return unknown
	 */
	public function getSkinCss(){

		$vs_File =Mage::getBaseDir('skin').DS.'interaktingslider'.DS.$this->getModel()->getSkin().'/style.css';

		try{
			$vs_Skin = file_get_contents($vs_File);
			$vs_Skin = str_replace("[[IMAGES_FOLDER]]", Mage::getBaseUrl('skin').'interaktingslider/'.$this->getModel()->getSkin().'/images', $vs_Skin);
			/**
			 * Réduction taille du code retourné
			 */
			
			// suppression commentaires
			$vs_Skin = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $vs_Skin);
			
			// suppresion retour chariot et tabulation 
  			$vs_Skin = str_replace(array("\t","\n","\r"), '', $vs_Skin); 
		}
		catch(Exception $e){
			$vs_Skin = "/*Skin file: $vs_File could not be read*/";
		}
		

		
		return trim($vs_Skin);
	}

}