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
        $categoryIds = array();
        $mailInfo = array();

        $categoryOther = $request->getParam('category_other');
        $subCategoryOther = $request->getParam('sub_category_other');
        $subCategory = $request->getParam('sub_category');
        
        if (!empty($categoryOther)) {
            $mailInfo['category'] = $categoryOther;
        } else {
            
            $recievedCategoryId = $request->getParam('category');
            $categoryIds[] = $recievedCategoryId;
        }

        if (!empty($subCategoryOther)) {
            $mailInfo['subcategory'] = $subCategoryOther;
        } else if ($subCategory != 0){
            $categoryIds[] = $subCategory;
        }

        // if New Make is required Implode add to array

    
        $product = Mage::getModel('catalog/product');

    	$product->setSku($request->getParam('sku'));
    	$product->setName($request->getParam('name'));
    	$product->setDescription($request->getParam('description'));
    	$product->setShortDescription($request->getParam('description'));
    	$product->setPrice(500);
    	$product->setTypeId('simple');
    	$product->setAttributeSetId(4);
        
        if (!isset($categoryIds)) {
    	   $product->setCategoryIds($categoryIds);
        }

    	$product->setWeight($request->getParam('weight'));
    	$product->setTaxClassId(2);
    	$product->setVisibility(4);
    	$product->setStatus(1);

        $product->setModel($request->getParam('model'));
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
        
        if (!empty($mailInfo)) {
        
            //send mail with the product Info as well as the Main Category Id, Subcategory Id, Make
            $to = 'richard@adodis.com';
            $dt = date('d-m-Y');
            $subject = "New Customer Suggestion for " . $dt;

            $message = "<html>
                <head>
                    <title></title>
                </head>
                <body>
                    <table border='1' cellpadding='4' cellspacing='0' width='60%'>
                        <tr>
                          <td align='center' colspan='2' height='30' ><b>New Customer Requirement</b></td>
                        </tr>
                        <tr>
                            <td align='right' width='40%'><b>Category:</b></td>
                            <td width='55%'>".$mailInfo['category']."</td>
                        </tr>
                        <tr>
                            <td align='right' width='40%'><b>Sub Category:</b></td>
                            <td width='55%'>".$mailInfo['subcategory']."</td>
                        </tr>
                    </table>
                </body>
                </html>";

            $mail = new Zend_Mail();
            $mail->setBodyHtml($message);
            $mail->setFrom('info@cbrme.com', 'Customer');
            $mail->addTo($to, 'Site Admin');
            $mail->setSubject($subject);

            $mail->send();
        }

        return $productId;
 
    }

    public function saveBannerAd()
    {
        $request = Mage::app()->getRequest();

        $sku = $request->getParam('company_name') . '-' . $_FILES['filename']['name'] . '-' . date("Y-m-d");

        $categoryIds =  array();

        $heavyEquipCategory = $request->getParam('heavyequipmentcategory');
        $truckCategory = $request->getParam('truckcategory');
        $craneCategory = $request->getParam('cranecategory');

        if (!empty($heavyEquipCategory)) {
            $categoryIds[] = $heavyEquipCategory;
        }

        if (!empty($truckCategory)) {
            $categoryIds[] = $truckCategory;
        }

        if (!empty($craneCategory)) {
            $categoryIds[] = $craneCategory;
        }


        $product = Mage::getModel('catalog/product');

        $product->setSku($sku);
        $product->setName($request->getParam('company_name'));
        $product->setDescription($request->getParam('company_name'));
        $product->setShortDescription($request->getParam('company_name'));

        $product->setBannerAd(25);

        if ($request->getParam('banner-ad-display-area') == 23)
        {
            $product->setPrice(500);
        } else if ($request->getParam('banner-ad-display-area') == 22) {
            $product->setPrice(200);
        } else

        switch ($request->getParam('banner-ad-display-area'))
        {
            case 23:
                $product->setPrice(500);
                break;

            case 22:
                $product->setPrice(200);
                break;

            case 21:
                $product->setPrice(200);
                break;

            case 20:
                $product->setPrice(400);
                break;
        }

        $product->setTypeId('simple');
        $product->setAttributeSetId(4);

        if (!isset($categoryIds)) {
           $product->setCategoryIds($categoryIds);
        }

        $product->setWeight(1);
        $product->setTaxClassId(2);
        $product->setVisibility(4);
        $product->setStatus(1);

        $product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));

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
