<?php

class Adodis_Customadvancedsearch_Model_Mysql4_Customadvancedsearch_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customadvancedsearch/customadvancedsearch');
    }
}
