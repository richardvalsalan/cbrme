<?php

class Adodis_Postad_Block_Adminhtml_Postad_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('postad_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('postad')->__('Item Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_section',
            array(
                'label' => Mage::helper('postad')->__('Item Information'),
                'title' => Mage::helper('postad')->__('Item Information'),
                'content' => $this->getLayout()->createBlock('postad/adminhtml_postad_edit_tab_form')->toHtml(),
            )
        );

        return parent::_beforeToHtml();
    }
}
