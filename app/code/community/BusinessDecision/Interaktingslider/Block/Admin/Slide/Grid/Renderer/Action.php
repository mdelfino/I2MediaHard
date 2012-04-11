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
 * Action du grid de gestion des slides
 */

class BusinessDecision_Interaktingslider_Block_Admin_Slide_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
	    public function render(Varien_Object $row)
	    {
	
	        $actions[] = array(
	        	'url' => $this->getUrl('*/*/edit', array('slide_id' => $row->getId())),
	        	'caption' => Mage::helper('interaktingslider')->__('Edit')
	         );
		     
	         $actions[] = array(
	        	'url' => $this->getUrl('*/*/delete', array('slide_id' => $row->getId())),
	        	'caption' => Mage::helper('interaktingslider')->__('Delete'),
	        	'confirm' => Mage::helper('interaktingslider')->__('Are you sure you want to delete this slide ?')
	         );
	
	        $va_Stores = $row->getAllStoreId();
	
	        if($va_Stores){
	        	foreach ($va_Stores as $vi_Store){
	
	
	
	        		  $actions[] = array(
	            		'url'     => $this->getUrl('*/*/preview', array(
	            									'slide_id'=>$row->getId(),'store_id'=>$vi_Store
	            								)),
	            		'popup'   => true,
	            		'caption' => Mage::helper('interaktingslider')->__('Preview in ').' '.Mage::app()->getStore($vi_Store)->getName()
	        			);
	        	}
	        }
	
	
	
	
	        $this->getColumn()->setActions($actions);
	
	        return parent::render($row);
	    }
}
