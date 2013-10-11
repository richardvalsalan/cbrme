<?php
class Adodis_Slideshow_Model_System_Config_Source_Yesno 
{

   public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Yes')),
            array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('No')),
        );
    }

}
?>