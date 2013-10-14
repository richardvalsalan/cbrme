<?php

class Adodis_Postad_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getAttributeOptions($attribute_code)
	{
		$attribute_details = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attribute_code);
		$options = $attribute_details->getSource()->getAllOptions(false);

		return $options;
	}
}
