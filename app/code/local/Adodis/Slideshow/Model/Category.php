<?php

class Adodis_Slideshow_Model_Category extends Mage_Core_Model_Abstract
{
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('slideshow/category');
    }
	public function getcat()
	{
	$options = Mage::getResourceModel('slideshow/category_collection')->load()->toOptionArray();		
    array_unshift($options, array('value'=>'', 'label'=>Mage::helper('slideshow')->__('Select Categories')));
    return $options;
	}
	
}