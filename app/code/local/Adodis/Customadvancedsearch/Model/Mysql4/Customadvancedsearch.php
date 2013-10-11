<?php

class Adodis_Customadvancedsearch_Model_Mysql4_Customadvancedsearch extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        // Note that the customadvancedsearch_id refers to the key field in your database table.
        $this->_init('customadvancedsearch/customadvancedsearch', 'customadvancedsearch_id');
    }
}
