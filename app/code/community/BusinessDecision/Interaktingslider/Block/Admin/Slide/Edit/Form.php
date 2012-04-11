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
 * Formulaire d'édition d'un slide
 */
class BusinessDecision_Interaktingslider_Block_Admin_Slide_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('slide_form');
        $this->setTitle(Mage::helper('interaktingslider')->__('Slide Information'));
    }
    
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if(Mage::helper('interaktingslider')->versionUseWysiwig()){
	        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
	            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
	            
	            $this->getLayout()->getBlock('head')->addJs('mage/adminhtml/variables.js');
	            $this->getLayout()->getBlock('head')->addJs('mage/adminhtml/wysiwyg/widget.js');
	            $this->getLayout()->getBlock('head')->addJs('lib/flex.js');
	            $this->getLayout()->getBlock('head')->addJs('lib/FABridge.js');
	            $this->getLayout()->getBlock('head')->addJs('mage/adminhtml/flexuploader.js');
	            $this->getLayout()->getBlock('head')->addJs('mage/adminhtml/browser.js');
	            $this->getLayout()->getBlock('head')->addJs('extjs/ext-tree.js');
	            $this->getLayout()->getBlock('head')->addJs('extjs/ext-tree-checkbox.js');

	            $this->getLayout()->getBlock('head')->addItem('js_css','extjs/resources/css/ext-all.css');
				$this->getLayout()->getBlock('head')->addItem('js_css','extjs/resources/css/ytheme-magento.css');
				$this->getLayout()->getBlock('head')->addItem('js_css','prototype/windows/themes/default.css');
				$this->getLayout()->getBlock('head')->addItem('js_css','prototype/windows/themes/magento.css');

	        }
        }
    }
        
	/**
	 * Définition du formulaire
	 *
	 * @return unknown
	 */
    protected function _prepareForm()
    {
        $model = Mage::registry('interaktingslider_slide');

        $form = new Varien_Data_Form(array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post'));

        $form->setHtmlIdPrefix('slide_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('interaktingslider')->__('General Information'), 'class' => 'fieldset-wide'));
        
        if ($model->getSlideId()) {
        	$fieldset->addField('slide_id', 'hidden', array(
                'name' => 'slide_id',
               
            ));
        }
        
        
		/**
		 * nom du slide
		 */
    	$fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('interaktingslider')->__('Name'),
            'title'     => Mage::helper('interaktingslider')->__('Name'),
            'required'  => true,
           
        ));

    	/**
         * vue magasin
         */
        if (!Mage::app()->isSingleStoreMode()) {
        	$fieldset->addField('store_id', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('interaktingslider')->__('Store View'),
                'title'     => Mage::helper('interaktingslider')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        }
        else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

       	/**
		 * Activé ou Désactivé
		 */
    	$fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('interaktingslider')->__('Status'),
            'title'     => Mage::helper('interaktingslider')->__('Status'),
            'name'      => 'is_active',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('interaktingslider')->__('Enabled'),
                '0' => Mage::helper('interaktingslider')->__('Disabled'),
            ),
         
        ));

		/**
		 * Date de début d'affichage
		 */
        $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM );
    	$fieldset->addField('from_time', 'date', array(
            'name'   => 'from_time',
            'time'   => true,
            'label'  => Mage::helper('interaktingslider')->__('From Time'),
            'title'  => Mage::helper('interaktingslider')->__('From Time'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format'    => $dateFormatIso,
            
        ));
        
        /**
		 * Date de fin d'affichage
		 */
        $fieldset->addField('to_time', 'date', array(
            'name'   => 'to_time',
            'time'   => true,
            'label'  => Mage::helper('interaktingslider')->__('To Time'),
            'title'  => Mage::helper('interaktingslider')->__('To Time'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
            'format'       => $dateFormatIso,
           
        ));
        
        /**
		 * Ajout du Wysiwyg de la 1.4
		 */ 
       if(Mage::helper('interaktingslider')->versionUseWysiwig()){
       $wysiwygConfig = Mage::getSingleton('interaktingslider/wysiwyg_config')->getConfig();
       }else{
       		$wysiwygConfig='';
       }
       
      
        /**
		 * Champs du contenu CMS
		 * id-css slide_content
		 */
    	$fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'label'     => Mage::helper('interaktingslider')->__('Content'),
            'title'     => Mage::helper('interaktingslider')->__('Content'),
            'style'     => 'height:36em',
           	'config'   => $wysiwygConfig,
            'required'  => true,
            
        ));
        
        $fieldset->addField('script_java', 'note', array(
            'text' => '<script type="text/javascript">
				            var inputDateFrom = document.getElementById(\'slide_from_time\');
				            var inputDateTo = document.getElementById(\'slide_to_time\');
            				inputDateTo.onchange=function(){dateTestAnterior(this)};
				            inputDateFrom.onchange=function(){dateTestAnterior(this)};
            				
				            
				            function dateTestAnterior(inputChanged){
				            	dateFromStr=inputDateFrom.value;
				            	dateToStr=inputDateTo.value;
				            	
				            	if(dateFromStr.indexOf(\'.\')==-1)
				            		dateFromStr=dateFromStr.replace(/(\d{1,2} [a-zA-Zâêûîôùàçèé]{3})[^ \.]+/,"$1.");
				            	if(dateToStr.indexOf(\'.\')==-1)
				            		dateToStr=dateToStr.replace(/(\d{1,2} [a-zA-Zâêûîôùàçèé]{3})[^ \.]+/,"$1.");
				            	
				            	fromDate= Date.parseDate(dateFromStr,"%e %b %Y %H:%M:%S");
				            	toDate= Date.parseDate(dateToStr,"%e %b %Y %H:%M:%S");
				            			            	
				            	if(dateToStr!=\'\'){
					            	if(fromDate>toDate){
	            						inputChanged.value=\'\';
	            						alert(\''.Mage::helper('interaktingslider')->__('You must set a date to value greater than the date from value').'\');
					            	}
				            	}
            				}
            			</script>',
            'disabled' => true
        ));

        $form->setValues($model->getData());
        
      
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
