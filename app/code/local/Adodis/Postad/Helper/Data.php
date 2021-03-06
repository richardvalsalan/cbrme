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

	public function getHeavyEquipmentFirstColCollection()
	{
		$category = Mage::getModel('catalog/category')->load(6);

		$productCollection = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToFilter('banner_ad', array(
				'eq' => '25'
			))
			->addCategoryFilter($category);

		foreach ($productCollection as $product)
		{
	
			$_product = Mage::getModel('catalog/product')->load($product->getId());

			$tmp[] = $_product->getName();
			
		}

		if (count($tmp) == 0) {

			$tmp[] = ' ';

			return $tmp;
		}

		return $tmp;
	}

	public function getTruckCollection()
	{
		$category = Mage::getModel('catalog/category')->load(53);

		$productCollection = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToFilter('banner_ad', array(
				'eq' => '25'
			))
			->addCategoryFilter($category);

		$i = 0;

		foreach ($productCollection as $product) {
			$i++;

			$_product = Mage::getModel('catalog/product')->load($product->getId());

			$tmp[] = $_product->getName();
			
		}

		if (count($tmp) == 0) {

			$tmp[] = ' ';

			return $tmp;
		}

		return $tmp;

	}

	public function getCraneCollection()
	{
		$category = Mage::getModel('catalog/category')->load(62);

		$productCollection = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToFilter('banner_ad', array(
				'eq' => '25'
			))
			->addCategoryFilter($category);

		foreach ($productCollection as $product) {
			$i++;

			$_product = Mage::getModel('catalog/product')->load($product->getId());

			$tmp[] = $_product->getName();
		
		}

		if (count($tmp) == 0) {

			$tmp[] = ' ';

			return $tmp;
		}

		return $tmp;
	}
}
