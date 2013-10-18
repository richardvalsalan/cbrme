<?php

class Adodis_Postad_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getAttributeOptions($attribute_code)
	{
		$attribute_details = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attribute_code);
		$options = $attribute_details->getSource()->getAllOptions(false);

		return $options;
	}

	public function buttonNeedToAppear($orderId)
	{
		$order = Mage::getModel('sales/order')->load($orderId);
		
		foreach ($order->getAllItems() as $item) {
			$product = Mage::getModel('catalog/product')->load($item->getProductId());

			if ($product->getStatus() == 2) {

				return true;
			}
		}

		return false;
	}
}
