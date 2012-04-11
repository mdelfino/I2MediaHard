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
 * BusinessDecision interaktingslider blocks grid
 * Gestionnaire des positions
 */
class BusinessDecision_Interaktingslider_Block_Admin_Position_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

  public function __construct()
    {
        parent::__construct();
        $this->setId('interaktingsliderPositionGrid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
    }
    
    
    /**
     * Prépare la liste des slides
     *
     * @return retourne la liste des slides
     */
    protected function _prepareCollection()
    {
    	$collection = Mage::getModel('interaktingslider/slide')->getCollection();
    	
    	if (Mage::registry('interaktingslider_store')->getId()) {
          
           $collection->addPositionFilter(Mage::registry('interaktingslider_store')); 
        }
  	
     
      
        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

     /**
     * Création des différentes colonnes du tableau d'administration
     *
     */
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();
        
         $this->addColumn('position', array(
        	'header'    => Mage::helper('interaktingslider')->__('Position'),
            'index'     => 'position',
            'align'     => 'center',
            'width'	   => '100px',
        ));
        
        $this->addColumn('name', array(
            'header'    => Mage::helper('interaktingslider')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));
        
        $this->addColumn('is_active', array(
            'header'    => Mage::helper('interaktingslider')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                0 => Mage::helper('interaktingslider')->__('Disabled'),
                1 => Mage::helper('interaktingslider')->__('Enabled')
            ),
        ));

        $this->addColumn('from_time', array(
            'header'    => Mage::helper('interaktingslider')->__('From Time'),
            'index'     => 'from_time',
            'type'      => 'datetime',
        ));

        $this->addColumn('to_time', array(
        	'header'    => Mage::helper('interaktingslider')->__('To Time'),
            'index'     => 'to_time',
            'type'      => 'datetime',
        ));
        
       
        
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('interaktingslider')->__('Move to'),
                'index'     =>'slide_id',
                'sortable' =>false,
                'filter'   => false,
                'no_link' => true,
                'width'	   => '175px',
                'renderer' => 'interaktingslider/admin_position_grid_renderer_action'
        ));

        return parent::_prepareColumns();
    }

     /**
     * Exécution après le chargement du grid
     *
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    
    /**
     * Redéfinition des conditions de filtre
     *
     * @param unknown_type $collection
     * @param unknown_type $column
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }
    
    /**
     * Exécution lors du clic sur une ligne du grid
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/admin_slide/edit', array('slide_id' => $row->getId(),'from_position' => 'true'));
    }
  
}
