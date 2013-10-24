<?php

class Adodis_Postad_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
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
    	
        $saveAdAndGetId = Mage::getModel('postad/postad')->saveAd();

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

                $product = Mage::getModel('catalog/product')->load($saveAdAndGetId);

                $product->addImageToMediaGallery($imgUrl , $mediaAttribute, false, false ); 
                $product->save();

                //deleting the images after saving the product
                unlink(Mage::getBaseDir('media') . DS . 'productUploadTempFolder/' . $_FILES['filename' . $i]['name']);

            }
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
