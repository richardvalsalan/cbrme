<?php

class Adodis_Postad_Block_Postad extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getPostad()
    {
        if (!$this->hasData('postad')) {
            $this->setData('postad', Mage::registry('postad'));
        }

        return $this->getData('postad');
    }

    public function getClassifiedSaveUrl()
    {
        return $this->getUrl('*/*/classifiedadsave');
    }
}
