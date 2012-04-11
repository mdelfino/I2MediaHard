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
 * Interaktingslider model Mysql4 Slide Collection
 */

class BusinessDecision_Interaktingslider_Model_Mysql4_Slide_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

	protected function _construct()
	{
		$this->_init('interaktingslider/slide');
	}

	public function toOptionArray()
	{
		return $this->_toOptionArray('slide_id', 'name');
	}

	/**
     * Add Filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @return BusinessDecision_Interaktingslider_Model_Mysql4_Slide_Collection
     */
	public function addStoreFilter($store, $withAdmin = true)
	{
		if ($store instanceof Mage_Core_Model_Store) {
			$store = array($store->getId());
		}

		$this->getSelect()->join(
		array('store_table' => $this->getTable('interaktingslider/slide_store')),
		'main_table.slide_id = store_table.slide_id',
		array()
		)
		->where('store_table.store_id in (?)', ($withAdmin ? array(0, $store) : $store));

		return $this;
	}

	/**
     * Ajoute les positions à la collection
     *
     * @param int|Mage_Core_Model_Store $store
     * @return BusinessDecision_Interaktingslider_Model_Mysql4_Slide_Collection
     */
	public function addPositionFilter($store)
	{
		if ($store instanceof Mage_Core_Model_Store) {
			$store = array($store->getId());
		}
		
		$model = Mage::getModel('interaktingslider/slide')->getCollection();		
		$model->addStoreFilter($store);
		
		foreach ($model->getItems() as $item){
			
			$this->getResource()->insertPositionIfNeeded($item,$store[0]);
		}

		$this->getSelect()->join(
		array('position_table' => $this->getTable('interaktingslider/slide_position')),
		'main_table.slide_id = position_table.slide_id',
		array('position_table.position')
		)
		->where('position_table.store_id in (?)', $store);	


		return $this;
	}

	/**
     * Ajoute a la collection un filtre sur les slides a afficher maintenant
     *
     */
	public function addNowFilter(){

		$vs_Now = Mage::getSingleton('core/date')->gmtDate();

		$vs_Where = "from_time < '".$vs_Now."' AND ((to_time > '".$vs_Now."') OR (to_time IS NULL))";

		$this->getSelect()->where($vs_Where);
	}


}