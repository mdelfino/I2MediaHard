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
 * Formulaire d'edition d'un slide
 */
class BusinessDecision_Interaktingslider_Block_Admin_Slide_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        //$this->_fromPosition = 'from_position';
    	$this->_objectId = 'slide_id';
        $this->_controller = 'admin_slide';
        $this->_blockGroup = 'interaktingslider';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('interaktingslider')->__('Save Slide'));
        $this->_updateButton('delete', 'label', Mage::helper('interaktingslider')->__('Delete Slide'));
        
        //En provenance du Grid de position
        if ($this->getRequest()->getParam('from_position')) {
        	$this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/admin_position/') . '\')');
        }
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        

        $this->_formScripts[] = "
           function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }
            
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            
        ";
    }

    /**
     * En-tete du formulaire d'édition
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('interaktingslider_slide')->getId()) {
            return Mage::helper('interaktingslider')->__("Edit Slide '%s'", $this->htmlEscape(Mage::registry('interaktingslider_slide')->getName()));
        }
        else {
            return Mage::helper('interaktingslider')->__('New Slide');
        }
    }

}
