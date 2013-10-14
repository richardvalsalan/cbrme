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

    public function classifiedadsaveAction()
    {
    	
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

                $product = Mage::getModel('catalog/product')->load(4);

                $product->addImageToMediaGallery($imgUrl , $mediaAttribute, false, false ); 
                $product->save();

                //deleting the images after saving the product
                unlink(Mage::getBaseDir('media') . DS . 'productUploadTempFolder/' . $_FILES['filename' . $i]['name']);

                // $product = Mage::getModel('catalog/product')->load()
            }
        }
        echo "done";
        die;

        $saveAd = Mage::getModel('postad/postad')->saveAd();
    	
    }
}
