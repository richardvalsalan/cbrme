<?php

class Adodis_Customadvancedsearch_Block_Customadvancedsearch extends Adodis_Customadvancedsearch_Block_Catalogsearch_Advanced_Form
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getCustomadvancedsearch()
    {
        if (!$this->hasData('customadvancedsearch')) {
            $this->setData('customadvancedsearch', Mage::registry('customadvancedsearch'));
        }

        return $this->getData('customadvancedsearch');
    }
}
