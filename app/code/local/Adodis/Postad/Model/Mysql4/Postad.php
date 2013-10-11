<?php

class Adodis_Postad_Model_Mysql4_Postad extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        // Note that the postad_id refers to the key field in your database table.
        $this->_init('postad/postad', 'postad_id');
    }
}
