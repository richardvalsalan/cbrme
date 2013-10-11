<?php

class Adodis_Slideshow_Model_Mysql4_Slideshow extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the slideshow_id refers to the key field in your database table.
        $this->_init('slideshow/slideshow', 'slideshow_id');
    }
}