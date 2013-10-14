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
    	
    	$product = Mage::getModel('catalog/product')->load(4);

    	$product->setSku('richi1');
    	$product->setName('richi_new');
    	$product->setDescription('richinew');
    	$product->setShortDescription('hello');
    	$product->setPrice(100);
    	$product->setTypeId('simple');
    	$product->setAttributeSetId(4);
    	$product->setCategoryIds(array(4));
    	$product->setWeight(0);
    	$product->setTaxClassId(2);
    	$product->setVisibility(4);
    	$product->setStatus(1);

    	$product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));

    	$stockData = $product->getStockData();
    	$stockData['qty'] = 20;
    	$stockData['is_in_stock'] = 1;
    	$stockData['manage_stock'] = 1;
    	$stockData['use_config_manage_stock'] = 0;
    	$product->setStockData($stockData);

    	echo "saved the product";
    	$product->save();

    	$allowedExts = array("gif", "jpeg", "jpg", "png");
    	$name = explode(".", $_REQUEST["file"]["name"]);
    	$extension = end($name);
    	// echo $_FILES["file"]["size"];
    	// die;

    	if (($_REQUEST["file"]["type"] == "image/jpeg" || $_REQUEST["file"]["type"] == "image/jpg" ) && ($_REQUEST["file"]["size"] < 2000000) && in_array($extension, $allowedExts)){
    		if ($_REQUEST["file"]["error"] > 0) {
	    		echo "Error: " . $_REQUEST["file"]["error"] . "<br>";
	    	} else {
	    		echo "Upload: " . $_REQUEST["file"]["name"] . "<br>";
	    		echo "Type: " . $_REQUEST["file"]["type"] . "<br>";
	    		echo "Size: " . ($_REQUEST["file"]["size"] / 1024) . " kB<br>";
	    		echo "Stored in: " . $_REQUEST["file"]["tmp_name"];
	    	}	
    	} else {
    		echo "Invalid file";
    	}

 
    }

    protected function _imageSaving()
    {
    	$allowedExts = array("gif", "jpeg", "jpg", "png");
    	$name = explode(".", $_FILES["file"]["name"]);
    	$extension = end($name);
    	// echo $_FILES["file"]["size"];
    	// die;

    	if (($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/jpg" ) && ($_FILES["file"]["size"] < 2000000) && in_array($extension, $allowedExts)){
    		if ($_FILES["file"]["error"] > 0) {
	    		echo "Error: " . $_FILES["file"]["error"] . "<br>";
	    	} else {
	    		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
	    		echo "Type: " . $_FILES["file"]["type"] . "<br>";
	    		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
	    		echo "Stored in: " . $_FILES["file"]["tmp_name"];
	    	}	
    	} else {
    		echo "Invalid file";
    	}
    }
}
