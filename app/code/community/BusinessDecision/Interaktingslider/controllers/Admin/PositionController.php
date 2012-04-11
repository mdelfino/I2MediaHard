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
 * Controleur de position du back office
 */
class BusinessDecision_Interaktingslider_Admin_PositionController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return BusinessDecision_Interaktingslider_Admin_StoreController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('interaktingslider/store')
            ->_addBreadcrumb(Mage::helper('interaktingslider')->__('Interaktingslider'), Mage::helper('interaktingslider')->__('Interaktingslider'))
            ->_addBreadcrumb(Mage::helper('interaktingslider')->__('Slides Positions'), Mage::helper('interaktingslider')->__('Slides Positions'))
        ;
        return $this;
    }
	
    /**
 	*	Index action
 	*/
    public function indexAction()
    {
    	if(Mage::helper('interaktingslider')->versionUseAdminTitle()){
    		$this->_title($this->__('Interaktingslider'));
    	}
    	
    	$vi_StoreId = $this->getRequest()->getParam('store');
    	
    	if(!$vi_StoreId){
    		$vi_StoreId = Mage::app()->getDefaultStoreView()->getId();
    	}
    	
    	$model = Mage::getModel('core/store');
    	
    	$model->load($vi_StoreId);
    	
    	if(!$model->getId()){
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('interaktingslider')->__("This store don't exist"));
    	}
    	
    	Mage::register('interaktingslider_store', $model);
    	
    	$vo_Switcher = $this->getLayout()->createBlock('adminhtml/store_switcher');
    	$vo_Switcher->hasDefaultOption(false);
    	$vo_Switcher->setUseConfirm(false);
    	
    	$vo_List = $this->getLayout()->createBlock('interaktingslider/admin_position');
    	
        $this->_initAction()
        	->_addContent($vo_Switcher)
            ->_addContent($vo_List)
            ->renderLayout();
            
    }
    
    /**
	 *  Move action 
	 */
    public function moveAction(){
    	
    	  $vi_StoreId = $this->getRequest()->getParam('store_id');
    	  $vi_SlideId = $this->getRequest()->getParam('slide_id');
    	  $vi_Position = $this->getRequest()->getParam('position');
    	  
    	  $vo_Slide = Mage::getModel('interaktingslider/slide')->load($vi_SlideId);
    	  
    	  $vo_Slide->setPosition($vi_StoreId,$vi_Position);
    	  
    	  $vo_Slide->save();
    	  
    	  Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('interaktingslider')->__("Slide '%s' was successfully updated",$vo_Slide->getName()));
                
    	 // go back to edit form
         $this->_redirect('*/*/', array('store' => $vi_StoreId));
         return;
    }

}

