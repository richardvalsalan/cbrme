<?php

class Adodis_Customadvancedsearch_Block_Adminhtml_Customadvancedsearch extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_customadvancedsearch';
        $this->_blockGroup = 'customadvancedsearch';
        $this->_headerText = Mage::helper('customadvancedsearch')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('customadvancedsearch')->__('Add Item');
        parent::__construct();
    }
}
