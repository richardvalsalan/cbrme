<?php

class Adodis_Postad_Block_Adminhtml_Postad extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_postad';
        $this->_blockGroup = 'postad';
        $this->_headerText = Mage::helper('postad')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('postad')->__('Add Item');
        parent::__construct();
    }
}
