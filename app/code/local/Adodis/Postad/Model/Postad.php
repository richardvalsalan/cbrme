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
    	$product->setPrice(500);
    	$product->setTypeId('simple');
    	$product->setAttributeSetId(4);
        
        $recievedCategoryId = $request->getParam('category');
        $categoryIds = $recievedCategoryId;

        //geting the parent id of the category selected
        $parentId = Mage::getModel('catalog/category')->load($recievedCategoryId)->getParentId();

        //using this if condition to check if the selected category is not a parent category (other than the root category)
        if ($parentId != 2) {
            $categoryIds = array($parentId, $recievedCategoryId);
        }


    	$product->setCategoryIds($categoryIds);
    	$product->setWeight($request->getParam('weight'));
    	$product->setTaxClassId(2);
    	$product->setVisibility(4);
    	$product->setStatus(1);

        $product->setYear($request->getParam('model'));
        $product->setYear($request->getParam('year'));
        $product->setHour($request->getParam('hours'));
        $product->setMake($request->getParam('make'));
        $product->setCondition($request->getParam('condition'));
        $product->setProductUseType($request->getParam('type_of_ad'));

    	$product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));

        $product->setProductState($request->getParam('state'));
        $product->setProductCity($request->getParam('city'));
        $product->setProductTelephone($request->getParam('telephone'));
        
    	$stockData = $product->getStockData();
    	$stockData['qty'] = 1;
    	$stockData['is_in_stock'] = 1;
    	$stockData['manage_stock'] = 1;
    	$stockData['use_config_manage_stock'] = 0;
    	$product->setStockData($stockData);

    	$productId = $product->save()->getId();

        return $productId;
 
    }

}
