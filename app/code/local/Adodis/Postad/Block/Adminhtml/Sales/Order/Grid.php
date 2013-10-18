<?php

class Adodis_Postad_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
	protected function _prepareColumns()
	{

		$this->addColumn('enable_ad', array(
            'header' => Mage::helper('sales')->__('Need To Enable Ad'),
            'index'     =>  'enable_ad',
        ));

        $this->addColumnsOrder('order_type', 'billing_name');

        return parent::_prepareColumns();
	}
}