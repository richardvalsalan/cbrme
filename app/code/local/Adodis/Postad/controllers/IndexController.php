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

                    // We set media as the upload dir
                    $path = Mage::getBaseDir('media') . DS ;

                    $upload->addValidator('FilesSize', false, array('max' => $this->_getUploadMaxFilesize()));

                    if ($upload->isUploaded($file) && $upload->isValid($file)) {
                        $uploader->save($path, $_FILES['filename']['name'] );
                    }



            } catch (Exception $e) {

            }    

            //this way the name is saved in DB
            $data['filename'] = $_FILES['filename']['name'];

            $mediaAttribute = array(
                    'thumbnail',
                    'small_image',
                    'image'
            );

            $imgUrl = Mage::getBaseDir('media') . DS . $_FILES['filename']['name'];

            $product = Mage::getModel('catalog/product')->load(4);

            $product->addImageToMediaGallery($imgUrl , $mediaAttribute, false, false ); 
            $product->save();

            // $product = Mage::getModel('catalog/product')->load()
        }
        echo "done";
        die;
        $saveAd = Mage::getModel('postad/postad')->saveAd();
    	
    }

    protected function _getUploadMaxFilesize()
    {
        return min($this->_getBytesIniValue('upload_max_filesize'), $this->_getBytesIniValue('post_max_size'));
    }

    protected function _getBytesIniValue($ini_key)
    {
        $_bytes = @ini_get($ini_key);

        // kilobytes
        if (stristr($_bytes, 'k')) {
            $_bytes = intval($_bytes) * 1024;
        // megabytes
        } elseif (stristr($_bytes, 'm')) {
            $_bytes = intval($_bytes) * 1024 * 1024;
        // gigabytes
        } elseif (stristr($_bytes, 'g')) {
            $_bytes = intval($_bytes) * 1024 * 1024 * 1024;
        }
        return (int)$_bytes;
    }

    protected function _isImage($fileInfo)
    {
        // Maybe array with file info came in
        if (is_array($fileInfo)) {
            return strstr($fileInfo['type'], 'image/');
        }

        // File path came in - check the physical file
        if (!is_readable($fileInfo)) {
            return false;
        }
        $imageInfo = getimagesize($fileInfo);
        if (!$imageInfo) {
            return false;
        }
        return true;
    }
}
