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
 * Interaktingslider manage Slides controller
 */
class BusinessDecision_Interaktingslider_Admin_SlideController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Mage_Adminhtml_Cms_BlockController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('interaktingslider/slide')
            ->_addBreadcrumb(Mage::helper('interaktingslider')->__('Interaktingslider'), Mage::helper('interaktingslider')->__('Interaktingslider'))
            ->_addBreadcrumb(Mage::helper('interaktingslider')->__('Interaktingslider Slides'), Mage::helper('interaktingslider')->__('Interaktingslider Slides'))
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
    	if(Mage::helper('interaktingslider')->versionUseAdminTitle()){
    		$this->_title($this->__('Interaktingslider'));
    	}
    	    	
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('interaktingslider/admin_slide'))
            ->renderLayout();
    }

    /**
     * Create new CMS block
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit CMS block
     */
    public function editAction()
    {
    	if(Mage::helper('interaktingslider')->versionUseAdminTitle()){
    		$this->_title($this->__('Interaktingslider'));
    	}
    	
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('slide_id');
        $model = Mage::getModel('interaktingslider/slide');
		
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('interaktingslider')->__('This slide no longer exists'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }
        
        // 4. Register model to use later in blocks
        Mage::register('interaktingslider_slide', $model);
		
        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('interaktingslider')->__('Edit Slide') : Mage::helper('interaktingslider')->__('New Slide'), $id ? Mage::helper('interaktingslider')->__('Edit Slide') : Mage::helper('interaktingslider')->__('New Slide'))
            ->_addContent($this->getLayout()->createBlock('interaktingslider/admin_slide_edit')->setData('action', $this->getUrl('*/admin_slide/save')))
            ->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            // init model and set data
            $model = Mage::getModel('interaktingslider/slide');
            $model->setData($data);
            
            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('interaktingslider')->__('Slide was successfully saved'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('slide_id' => $model->getId()));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/*/edit', array('slide_id' => $this->getRequest()->getParam('slide_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('slide_id')) {
            $name = "";
            try {
                // init model and delete
                $model = Mage::getModel('interaktingslider/slide');
                $model->load($id);
                $name = $model->getName();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('interaktingslider')->__('Slide was successfully deleted'));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('slide_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('interaktingslider')->__('Unable to find a slide to delete'));
        // go to grid
        $this->_redirect('*/*/');
    }

    public function previewAction ()
    {
    	// récupération du store Id de l'admin
    	$vi_AdminStore = Mage::app()->getStore()->getId();
    	
    	// lecture des parametres
    	$id = $this->getRequest()->getParam('slide_id');	
    	$store = $this->getRequest()->getParam('store_id');
    	
    	// chargement du slide
        $model = Mage::getModel('interaktingslider/slide');        
        $model->load($id);
    	
    	//Ajout des JS a la page pour les effets de transition
    	echo '
    	<html><head>  
    		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    		<title>'.Mage::helper('interaktingslider')->__('Preview of').' '.$model->getName().'</title>
		</head>';
    	
    	echo "<body>";
    	echo '<script type="text/javascript" src="'.Mage::getBaseUrl('js').'index.php?c=auto&amp;f=,prototype/prototype.js,scriptaculous/builder.js,scriptaculous/effects.js"></script>';

               
       	// On se place dans le bon store pour obtenir le skin voulu
        Mage::app()->setCurrentStore($store);
        
        // Chargement du bloc Preview du Interaktingslider
        $block = $this->getLayout()->createBlock('interaktingslider/admin_preview');
        
        // ajout de notre slide
		$block->addSlide($model);
		
		// affichage
        echo $block->toHtml();
        
        Mage::app()->setCurrentStore($vi_AdminStore);

        echo "</body></html>";
        
    }
    
  
    
    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('interaktingslider/slide');
    }
    
    
     /**
     * WYSIWYG editor action for ajax request
     *
     */
    public function wysiwygAction()
    {
        $elementId = $this->getRequest()->getParam('element_id', md5(microtime()));
        $content = $this->getLayout()->createBlock('adminhtml/catalog_helper_form_wysiwyg_content', '', array(
            'editor_element_id' => $elementId
        ));
        $this->getResponse()->setBody($content->toHtml());
    }
}