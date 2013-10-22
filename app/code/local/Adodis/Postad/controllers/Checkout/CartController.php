<?php

require_once(Mage::getModuleDir('controllers','Mage_Checkout').DS.'CartController.php');

class Adodis_Postad_Checkout_CartController extends Mage_Checkout_CartController
{
	public function deleteAction()
	{
		$product_id = $this->getRequest()->getParam('product');

		Mage::register("isSecureArea", 1);
		Mage::getModel("catalog/product")->load($product_id)->delete();

		return parent::deleteAction();
	}
}