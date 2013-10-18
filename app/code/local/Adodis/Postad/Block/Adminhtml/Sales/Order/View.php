<?php

class Adodis_Postad_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{
	public function __construct()
	{
		
		if (Mage::helper('postad')->buttonNeedToAppear($this->getOrder()->getId())) {
            $this->_addButton('post_ad', array(
                    'label'     => Mage::helper('sales')->__('Post Ad'),
                    'onclick'   => 'setLocation(\'' . $this->getUrl('postad/adminhtml_postad/postad') . '\')',
            ));
        }
        
        return parent::__construct();
	}
}