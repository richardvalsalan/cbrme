<?php

class Adodis_Postad_Model_Postad extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('postad/postad');
    }

    public function saveAd()
    {
    	$request = Mage::app()->getRequest();
    
        $product = Mage::getModel('catalog/product');

    	$product->setSku($request->getParam('sku'));
    	$product->setName($request->getParam('name'));
    	$product->setDescription($request->getParam('description'));
    	$product->setShortDescription($request->getParam('description'));
    	$product->setPrice(100);
    	$product->setTypeId('simple');
    	$product->setAttributeSetId(4);
    	$product->setCategoryIds(array($request->getParam('category')));
    	$product->setWeight($request->getParam('weight'));
    	$product->setTaxClassId(2);
    	$product->setVisibility(4);
    	$product->setStatus(1);

        $product->setYear($request->getParam('year'));
        $product->setHour($request->getParam('hours'));
        $product->setMake($request->getParam('make'));
        $product->setCondition($request->getParam('condition'));
        $product->setProductUseType($request->getParam('type_of_ad'));

    	$product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));

    	$stockData = $product->getStockData();
    	$stockData['qty'] = 1;
    	$stockData['is_in_stock'] = 1;
    	$stockData['manage_stock'] = 1;
    	$stockData['use_config_manage_stock'] = 0;
    	$product->setStockData($stockData);

    	echo "saved the product";
    	$productId = $product->save()->getId();

        return $productId;
 
    }

}
