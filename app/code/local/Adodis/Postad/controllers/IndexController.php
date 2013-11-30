<?php

class Adodis_Postad_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function contactAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function adoptionsAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function contactprocessAction()
    {
        if($this->getRequest()->getParams()) {
            $to = 'shirdisaicorporate@gmail.com';
            $dt = date('d-m-Y');
            $subject = "contact of  " . $dt;

            $message = "<html>
                <head>
                    <title></title>
                </head>
                <body>
                    <table border='1' cellpadding='4' cellspacing='0' width='60%'>
                        <tr>
                          <td align='center' colspan='2' height='30' ><b>Contact Info</b></td>
                        </tr>
                        <tr>
                            <td align='right' width='40%'><b>Name:</b></td>
                            <td width='55%'>".$this->getRequest()->getParam('contact-name')."</td>
                        </tr>
                        <tr>
                            <td align='right' width='40%'><b>Email :</b></td>
                            <td width='55%'>".$this->getRequest()->getParam('contact-email')."</td>
                        </tr>
                        <tr>
                            <td align='right' width='40%'><b>Contact No:</b></td>
                            <td width='55%'>".$this->getRequest()->getParam('contact-no')."</td>
                        </tr>
                        <tr>
                            <td align='right' width='40%'><b>Contact Message:</b></td>
                            <td width='75%'>".$this->getRequest()->getParam('contact-message')."</td>
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

            Mage::getSingleton('core/session')->addSuccess($this->_('The Contact Mail has been send'));

            $this->_redirect();

            return;
        }
    }

    public function classifiedadAction()
    {
    	$this->loadLayout();
        $this->renderLayout();
    }

    public function subcategoryAction()
    {
        $categoryId = $this->getRequest()->getParam('categoryid');

        $hasChildren = Mage::getModel('catalog/category')->load($categoryId)->getChildren();

        if (!empty($hasChildren)) {

            $subcategories = Mage::getModel('catalog/category')->getCategories($categoryId);

            $tmp = array();
            $return = array();
            
            $tmp['0'] = 'Choose';

            foreach($subcategories as $subcategory)
            {
                $tmp[$subcategory->getId()] = $subcategory->getName();
            }

            $tmp['other_sub'] = 'Other';

            echo json_encode($tmp);
        }

    }

    public function classifiedadsaveAction()
    {
        $request = Mage::app()->getRequest();
    
        $typeofAd = $request->getParam('type_of_ad');
        $category = $request->getParam('category');
        $categoryOther = $request->getParam('category_other');
        $subCategory = $request->getParam('sub_category');
        $subCategoryOther = $request->getParam('sub_category_other');
        $companyName = $request->getParam('name');
        $description = $request->getParam('description');
        $make = $request->getParam('make');
        $newMake = $request->getParam('new-make');
        $model = $request->getParam('model');
        $condition = $request->getParam('condition');
        $address = $request->getParam('address');
        $state = $request->getParam('state');
        $newState = $request->getParam('add_new_state');
        $city = $request->getParam('city');
        $newCity = $request->getParam('add_new_city');
        $landLine = $request->getParam('telephone');
        $mobile = $request->getParam('mobile_telephone');
        $email = $request->getParam('email');
        $website = $request->getParam('website');
        $zipcode = $request->getParam('zipcode');

        $previousUrl = $request->getParam('current_url');

        if (empty($typeofAd) || empty($companyName) || empty($description) || empty($address) || empty($landLine) || empty($mobile) || empty($email) || empty($website) || empty($zipcode)) {
            
            Mage::getSingleton('core/session')->addError('Some of the Required Fields has not been filled.Please Fill Them Correctly');
            return $this->_redirectUrl($previousUrl);
        }
        
        if (empty($category)) {
            Mage::getSingleton('core/session')->addError('Category is not selected.Please Select a main category');
            return $this->_redirectUrl($previousUrl);
        }
        
        if ($subCategory == "other_sub") {
            if (empty($subCategoryOther)) {
                Mage::getSingleton('core/session')->addError('Sub-Category is not selected.Please Select a main category');
                return $this->_redirectUrl($previousUrl);
            }
        } else if (empty($subCategory)) {
            Mage::getSingleton('core/session')->addError('Sub-Category is not selected.Please Select a main category');
            return $this->_redirectUrl($previousUrl);
        }
        
        if (!empty($typeofAd)) {
            
            if ($typeofAd == '5' || $typeofAd == '4') {
                if(empty($condition)) {
                    Mage::getSingleton('core/session')->addError('Condition has not been Selected.Please Fill It');
                    return $this->_redirectUrl($previousUrl);
                }
            }
        } 

        if (empty($state)) {
            Mage::getSingleton('core/session')->addError('State has not been Selected.Please Select It');
            return $this->_redirectUrl($previousUrl);    
        } else if ($state == "other_state") {
            if (empty($newState)) {
                Mage::getSingleton('core/session')->addError('Please Enter The New State');
                return $this->_redirectUrl($previousUrl);
            }
        }

        if (empty($city)) {
            Mage::getSingleton('core/session')->addError('City has not been Selected.Please Select It');
            return $this->_redirectUrl($previousUrl);
        } else if ($city == "other_city") {
            if (empty($newCity)) {
                Mage::getSingleton('core/session')->addError('Please Enter The New State');
                return $this->_redirectUrl($previousUrl);
            }
        }

       
        if (empty($make)) {
            if($typeofAd != "3") {
                if (empty($newMake)) {
                    Mage::getSingleton('core/session')->addError('Please Ad the New Make not been Selected.Please Select It');
                    return $this->_redirectUrl($previousUrl);
                }
            }
        }

        if (empty($model)) {
            if($typeofAd != "3") {
                Mage::getSingleton('core/session')->addError('Model has not been Entered.Please Enter It');
                return $this->_redirectUrl($previousUrl);
            }
        }
        

        $saveAdAndGetId = Mage::getModel('postad/postad')->saveAd();
        $product = Mage::getModel('catalog/product')->load($saveAdAndGetId);

        for ($i = 1; $i <= 4 ; $i++ ) {
            
            if (isset($_FILES['filename' . $i]['name']) && $_FILES['filename' . $i]['name'] != '') {
                try {

                    /* Starting upload */
                        $uploader = new Varien_File_Uploader('filename' . $i);

                        // Any extention would work
                        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));

                        $uploader->setAllowRenameFiles(false);

                        // Set the file upload mode
                        // false -> get the file directly in the specified folder
                        // true -> get the file in the product like folders
                        //  (file.jpg will go in something like /media/f/i/file.jpg)
                        $uploader->setFilesDispersion(false);

                        // We set media as the upload dir
                        $path = Mage::getBaseDir('media') . DS  . 'productUploadTempFolder/';

                        $uploader->save($path, $_FILES['filename' . $i]['name'] );
                        



                } catch (Exception $e) {
                    Mage::getSingleton('core/session')->addError($this->_('There has Been an error,while upload.Please try a little later'));
                }    

                //this way the name is saved in DB
                $data['filename'] = $_FILES['filename' . $i]['name'];

                $mediaAttribute = array(
                        'thumbnail',
                        'small_image',
                        'image'
                );

                $imgUrl = Mage::getBaseDir('media') . DS . 'productUploadTempFolder/' . $_FILES['filename' . $i]['name'];

                $product->addImageToMediaGallery($imgUrl , $mediaAttribute, false, false ); 
                $product->save();

                //deleting the images after saving the product
                unlink(Mage::getBaseDir('media') . DS . 'productUploadTempFolder/' . $_FILES['filename' . $i]['name']);

            }
        }
        
    	$this->_addToCart($product);
    }

    public function banneradsaveAction()
    {
        $saveAdAndGetId = Mage::getModel('postad/postad')->saveBannerAd();

        $product = Mage::getModel('catalog/product')->load($saveAdAndGetId);
        $sku = $product->getSku();
        
        if (isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
            try {

                /* Starting upload */
                $uploader = new Varien_File_Uploader('filename');

                // Any extention would work
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));

                $uploader->setAllowRenameFiles(false);

                // Set the file upload mode
                // false -> get the file directly in the specified folder
                // true -> get the file in the product like folders
                //  (file.jpg will go in something like /media/f/i/file.jpg)

                $uploader->setFilesDispersion(false);

                mkdir(Mage::getBaseDir('media') . DS  . 'bannerimages' . DS  . $sku);

                // We set media as the upload dir
                $path = Mage::getBaseDir('media') . DS  . 'bannerimages/' . $sku;
                
                $uploader->save($path, $_FILES['filename']['name'] );
                
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError($this->_('There has Been an error,while upload.Please try a little later'));
            }

            //this way the name is saved in DB
            $data['filename'] = $_FILES['filename']['name'];

            $mediaAttribute = array(
                    'thumbnail',
                    'small_image',
                    'image'
            );

            $imgUrl = Mage::getBaseDir('media') . DS  . 'bannerimages/' . $sku . '/' . $_FILES['filename']['name'];

            $product->addImageToMediaGallery($imgUrl , $mediaAttribute, false, false ); 
            $product->save();
        }

        $this->_addToCart($product);
    }

    protected function _addToCart($product)
    {
        $cart = $this->_getCart();

        $eventArgs = array(
            'product' => $product,
            'qty' => 1
        );

        try {

            Mage::dispatchEvent('checkout_cart_before_add', $eventArgs);

            $cart->addProduct($product);

            Mage::dispatchEvent('checkout_cart_after_add', $eventArgs);

            $cart->save();

            Mage::dispatchEvent('checkout_cart_add_product', array('product'=>$product));

            $message = $this->__('%s was successfully added to your shopping cart.', $product->getName());    
            Mage::getSingleton('checkout/session')->addSuccess($message);

        } catch (Exception $e) {
            Mage::getSingleton('checkout/session')->addException($e, $this->__('Can not add item to shopping cart'));
        }

        return $this->_redirect('checkout/cart');
    }

    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    public function banneradAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
