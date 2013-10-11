<?php

class Adodis_Slideshow_Model_Mysql4_Category_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('slideshow/category');
			
        $this->_map['fields']['category_id'] = 'main_table.category_id';
        $this->_map['fields']['store']   = 'store_table.store_id';
    }
	public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }
	     public function toOptionArray()
    {

        return $this->_toOptionArray('category_id', 'title');

    }
	protected function _afterLoad()
    {
        if ($this->_previewFlag) {
            $items = $this->getColumnValues('category_id');
            if (count($items)) {
                $select = $this->getConnection()->select()
                        ->from($this->getTable('category_store'))
                        ->where($this->getTable('category_store').'.category_id IN (?)', $items);
                if ($result = $this->getConnection()->fetchPairs($select)) {
                    foreach ($this as $item) {
                        if (!isset($result[$item->getData('category_id')])) {
                            continue;
                        }
                        if ($result[$item->getData('category_id')] == 0) {
                            $stores = Mage::app()->getStores(false, true);
                            $storeId = current($stores)->getId();
                            $storeCode = key($stores);
                        } else {
                            $storeId = $result[$item->getData('category_id')];
                            $storeCode = Mage::app()->getStore($storeId)->getCode();
                        }
                        $item->setData('_first_store_id', $storeId);
                        $item->setData('store_code', $storeCode);
                    }
                }
            }
        }

        parent::_afterLoad();
    }
	    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @return Mage_Cms_Model_Mysql4_Page_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }
       echo  $this->addFilter('store', array('in' => ($withAdmin ? array(0, $store) : $store)), 'public');
        return $this;
    }
	
	    /**
     * Join store relation table if there is store filter
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('category_store')),
                'main_table.category_id = store_table.category_id',
                array()
            )->group('main_table.category_id');
        }
        return parent::_renderFiltersBefore();
    }
}