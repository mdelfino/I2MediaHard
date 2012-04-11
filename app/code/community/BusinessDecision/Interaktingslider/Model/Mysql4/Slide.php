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
 * Interaktingslider model mysql4 d'un slide
 */

class BusinessDecision_Interaktingslider_Model_Mysql4_Slide extends Mage_Core_Model_Mysql4_Abstract
{

	protected function _construct()
	{
		$this->_init('interaktingslider/slide', 'slide_id');
	}

	/**
     *Opération à éffectuer avant la sauvegarde en base
     *
     * @param Mage_Core_Model_Abstract $object
     */
	protected function _beforeSave(Mage_Core_Model_Abstract $object)
	{	
		$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		 
		if (! $object->getFromTime()) {
			$object->setFromTime(Mage::getSingleton('core/date')->gmtDate());
		}
		else{
			
			$object->setFromTime( Mage::app()->getLocale()->date($object->getFromTime(),$dateFormatIso));
	
			$object->setFromTime($object->getFromTime()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
			
			$object->setFromTime(Mage::getSingleton('core/date')->gmtDate(null,$object->getFromTime())); 
		}

		if (! $object->getToTime()) {
			$object->setToTime();
		}
		else{
			
			$object->setToTime( Mage::app()->getLocale()->date($object->getToTime(),$dateFormatIso));
	
			$object->setToTime($object->getToTime()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT));
			
			$object->setToTime(Mage::getSingleton('core/date')->gmtDate(null,$object->getToTime()));
		}
		
		return $this;
	}

	/**
	 * Opération a effectuer aprés la sauvegarde en base
     *
     * @param Mage_Core_Model_Abstract $object
     */
	protected function _afterSave(Mage_Core_Model_Abstract $object)
	{
		$condition = $this->_getWriteAdapter()->quoteInto('slide_id = ?', $object->getId());

		$this->_getWriteAdapter()->delete($this->getTable('interaktingslider/slide_store'), $condition);
		
		if(!$object->getData('stores')){
			$object->setData('stores',$object->getData('store_id'));
		}

		if(in_array(0,$object->getData('stores'))){
			$object->setData('stores',array(0));
		}
		
		foreach ((array)$object->getData('stores') as $store) {
			$storeArray = array();
			$storeArray['slide_id'] = $object->getId();
			$storeArray['store_id'] = $store;
			$this->_getWriteAdapter()->insert($this->getTable('interaktingslider/slide_store'), $storeArray);

		}
		
		// Liste des store présent dans position pour le slide courant
		$select = $this->_getReadAdapter()->select()
		->from($this->getTable('interaktingslider/slide_position'))
		->where('slide_id = ?', $object->getId());

		foreach($data = $this->_getReadAdapter()->fetchAll($select) as $store_id_in_slide) {
			//pour tous les stores du slide dans position
			if(!in_array(0,$object->getData('stores'))){
				if(!in_array($store_id_in_slide['store_id'],$object->getData('stores'))){
				 	//Si il n'y a pas de correspondance entre le slide et le store
					$this->_deletePosition($object,$store_id_in_slide['store_id']);
				}
			}
		}		

		//Gestion des positions du slide
		if($object->getPositions()){
			foreach ($object->getPositions() as $store => $position){
				$this->_movePosition($object,$store,$position);
			}
		}

		return parent::_afterSave($object);
	}

	/**
	 * Chargement de la config
	 *
	 * @param Mage_Core_Model_Abstract $object
	 * @param unknown_type $value
	 * @param unknown_type $field
	 * @return unknown
	 */
	public function load(Mage_Core_Model_Abstract $object, $value, $field=null)
	{
		if (!intval($value) && is_string($value)) {
			$field = 'name';
		}
		return parent::load($object, $value, $field);
	}

	/**
	 * Execution avant suppression
	 *
	 * @param Mage_Core_Model_Abstract $object
	 */
	protected function _beforeDelete(Mage_Core_Model_Abstract $object){
		//Gestion des déplacements de slide
		if($object->getPositions()){
			foreach ($object->getPositions() as $store => $position){
				$this->_deletePosition($object,$store);
			}
		}
	}

	/**
     * Exécution aprés chargement
     * 
     * @param Mage_Core_Model_Abstract $object
     */
	protected function _afterLoad(Mage_Core_Model_Abstract $object)
	{
		// Liste des stores
		$select = $this->_getReadAdapter()->select()
		->from($this->getTable('interaktingslider/slide_store'))
		->where('slide_id = ?', $object->getId());

		if ($data = $this->_getReadAdapter()->fetchAll($select)) {
			$storesArray = array();
			foreach ($data as $row) {
				$storesArray[] = $row['store_id'];
			}
			$object->setData('store_id', $storesArray);
		}

		// Liste des positions
		$select = $this->_getReadAdapter()->select()
		->from($this->getTable('interaktingslider/slide_position'))
		->where('slide_id = ?', $object->getId());

		if ($data = $this->_getReadAdapter()->fetchAll($select)) {
			$va_Position = array();
			foreach ($data as $row) {
				$va_Position[$row['store_id']] = $row['position'];
			}
			$object->setData('positions', $va_Position);
		}
		
		return parent::_afterLoad($object);
	}

	/**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @return Zend_Db_Select
     */
	protected function _getLoadSelect($field, $value, $object)
	{

		$select = parent::_getLoadSelect($field, $value, $object);

		if ($object->getStoreId()) {
			$select->join(array('cbs' => $this->getTable('interaktingslider/slide_store')), $this->getMainTable().'.slide_id = cbs.slide_id')
			->where('is_active=1 AND cbs.store_id in (0, ?) ', $object->getStoreId())
			->order('store_id DESC')
			->limit(1);
		}
		return $select;
	}

	/**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
	public function lookupStoreIds($id)
	{
		return $this->_getReadAdapter()->fetchCol($this->_getReadAdapter()->select()
		->from($this->getTable('interaktingslider/slide_store'), 'store_id')
		->where("{$this->getIdFieldName()} = ?", $id)
		);
	}


	protected function _getSlidesPositions($pi_StoreId){

		$va_SlidesPositions = array();

		//Récupération des positions
		$select = $this->_getReadAdapter()->select()
		->from($this->getTable('interaktingslider/slide_position'))
		->where('store_id = ?', $pi_StoreId);

		if ($data = $this->_getReadAdapter()->fetchAll($select)) {
			foreach ($data as $row){
				$va_SlidesPositions[$row['position']]=$row['slide_id'];
			}
		}

		return $va_SlidesPositions;
	}

	/**
	 * Sauvegarde des positions des slides d'un store
	 *
	 * @param integer $pi_StoreId identifiant du store
	 * @param array $pa_Positions tableau des positions des slides
	 */
	protected function _saveSlidesPositions($pi_StoreId,$pa_Positions){

		$condition = $this->_getWriteAdapter()->quoteInto('store_id = ?', $pi_StoreId);
		$this->_getWriteAdapter()->delete($this->getTable('interaktingslider/slide_position'), $condition);

		foreach ($pa_Positions as $position => $slideId) {

			$slideArray = array();
			$slideArray['slide_id'] = $slideId;
			$slideArray['store_id'] = $pi_StoreId;
			$slideArray['position'] = $position;

			$this->_getWriteAdapter()->insert($this->getTable('interaktingslider/slide_position'), $slideArray);
		}
	}

	/**
	 * Récupére la derniere position
	 *
	 * @param unknown_type $pi_StoreId
	 * @return unknown
	 */
	protected function _getLastPosition($pi_StoreId){
		return count($this->_getSlidesPositions($pi_StoreId))+1;
	}


	/**
     * Création de la postition du slide dans le store view si il n'y en a pas
     *
     * @param Mage_Core_Model_Abstract $object le slide a positionnner
     * @param integer $pi_StoreId identifgiant du store
     * @return boolean
     */
	public function insertPositionIfNeeded(Mage_Core_Model_Abstract $object,$pi_StoreId){

		// Liste des positions défini pour le slide dans le store view
		$select = $this->_getReadAdapter()->select()
		->from($this->getTable('interaktingslider/slide_position'))
		->where('store_id = ?', $pi_StoreId)
		->where('slide_id = ?', $object->getId());

		if ($data = $this->_getReadAdapter()->fetchAll($select)) {
			// la position est définie
			return false;
		}

		// Insertion de l'enregistrement défini
		$storeArray = array();
		$storeArray['slide_id'] = $object->getId();
		$storeArray['store_id'] = $pi_StoreId;
		$storeArray['position'] = $this->_getLastPosition($pi_StoreId);
		$this->_getWriteAdapter()->insert($this->getTable('interaktingslider/slide_position'), $storeArray);
	}

	/**
	 * Tri des positions
	 *
	 * @param unknown_type $va_SlidesPositions
	 * @param unknown_type $pi_New
	 * @param unknown_type $pi_Old
	 * @return unknown
	 */
	protected function _sortPostition($va_SlidesPositions,$pi_New,$pi_Old){

		$vi_Pointer = $pi_Old;

		if($pi_New < $pi_Old){
			//permutations à gauche
			while($vi_Pointer > $pi_New){
				$vi_Temp = $va_SlidesPositions[$vi_Pointer-1];
				$va_SlidesPositions[$vi_Pointer-1] = $va_SlidesPositions[$vi_Pointer];
				$va_SlidesPositions [$vi_Pointer] = $vi_Temp;
				$vi_Pointer--;
			}
		}
		else{
			//permutations à droite
			while($vi_Pointer < $pi_New){
				$vi_Temp = $va_SlidesPositions[$vi_Pointer+1];
				$va_SlidesPositions[$vi_Pointer+1] = $va_SlidesPositions[$vi_Pointer];
				$va_SlidesPositions [$vi_Pointer] = $vi_Temp;
				$vi_Pointer++;
			}
		}

		return $va_SlidesPositions;
	}

	/**
	 * Déplacement de la position slide
	 *
	 * @param Mage_Core_Model_Abstract $object
	 * @param unknown_type $pi_StoreId
	 * @param unknown_type $pi_Position
	 * @return unknown
	 */
	protected function _movePosition(Mage_Core_Model_Abstract $object,$pi_StoreId,$pi_Position){


		$va_SlidesPositions = $this->_getSlidesPositions($pi_StoreId);

		//tri du tableau avec nouvelle position

		$vi_NewPosition = $pi_Position;
		$vi_OldPosition = array_search($object->getId(),$va_SlidesPositions);

		if($vi_NewPosition==$vi_OldPosition){
			// si la position ne change pas on sort
			return true;
		}
		$va_SlidesPositions = $this->_sortPostition($va_SlidesPositions,$vi_NewPosition,$vi_OldPosition);

		$this->_saveSlidesPositions($pi_StoreId,$va_SlidesPositions);

	}


	/**
	 * Retire la position d'un slide d'un store 
	 *
	 * @param object $object	l'objet slide
	 * @param integer $pi_StoreId l'identifiant du store
	 */
	protected function _deletePosition(Mage_Core_Model_Abstract $object,$pi_StoreId){

		$va_SlidesPositions = $this->_getSlidesPositions($pi_StoreId);

		//tri du tableau avec nouvelle position

		$vi_NewPosition = $this->_getLastPosition($pi_StoreId)-1;
		$vi_OldPosition = array_search($object->getId(),$va_SlidesPositions);

		if($vi_NewPosition!=$vi_OldPosition){
			$va_SlidesPositions = $this->_sortPostition($va_SlidesPositions,$vi_NewPosition,$vi_OldPosition);
		}

		unset($va_SlidesPositions[$vi_NewPosition]);

		$this->_saveSlidesPositions($pi_StoreId,$va_SlidesPositions);

	}

}