<?php

class Adodis_Slideshow_Model_Mysql4_Category extends Mage_Core_Model_Mysql4_Abstract
{
	protected $_store = null;
    public function _construct()
    {    
        // Note that the slideshow_id refers to the key field in your database table.
        $this->_init('slideshow/category', 'category_id');
    }

	 protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        $storeId = $object->getStoreId();
        if ($storeId) {
            $select->join(
                        array('cps' => $this->getTable('category_store')),
                        $this->getMainTable().'.category_id = `cps`.category_id'
                    )
                    ->where('is_active=1 AND `cps`.category_id IN (' . Mage_Core_Model_App::ADMIN_STORE_ID . ', ?) ', $storeId)
                    ->order('store_id DESC')
                    ->limit(1);
        }
        return $select;
    }
protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('category_store'))
            ->where('category_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }

        return parent::_afterLoad($object);
    }
	
	public function addStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }
        $this->addFilter('store', array('in' => ($withAdmin ? array(0, $store) : $store)), 'public');
        return $this;
    }
	public function addIsActiveFilter()
    {
        $this->addFilter('status', 1);
        return $this;
    }	
	protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (! $object->getId()) {
            $object->setCreatedTime(Mage::getSingleton('core/date')->gmtDate());
        }
        $object->setUpdateTime(Mage::getSingleton('core/date')->gmtDate());
        return $this;
    }
	
	protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $condition = $this->_getWriteAdapter()->quoteInto('category_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('category_store'), $condition);

        foreach ((array)$object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['category_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('category_store'), $storeArray);
        }

        return parent::_afterSave($object);
    }
	    public function lookupStoreIds($id)
    {
        return $this->_getReadAdapter()->fetchCol($this->_getReadAdapter()->select()
            ->from($this->getTable('category_store'), 'store_id')
            ->where("{$this->getIdFieldName()} = ?", $id)
        );
    }
	    public function setStore($store)
    {
        $this->_store = $store;
        return $this;
    }
	
	   public function getStore()
    {
        return Mage::app()->getStore($this->_store);
    }

	
}