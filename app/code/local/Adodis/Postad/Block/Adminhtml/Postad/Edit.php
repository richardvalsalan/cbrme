<?php

class Adodis_Postad_Block_Adminhtml_Postad_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'postad';
        $this->_controller = 'adminhtml_postad';

        $this->_updateButton(
            'save',
            'label',
            Mage::helper('postad')->__('Save Item')
        );

        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('postad')->__('Delete Item')
        );

        $this->_addButton(
            'saveandcontinue',
            array(
                'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class' => 'save',
            ),
            -100
        );

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('postad_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'postad_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'postad_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('postad_data') && Mage::registry('postad_data')->getId()) {
            return Mage::helper('postad')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('postad_data')->getTitle()));
        }
        else {
            return Mage::helper('postad')->__('Add Item');
        }
    }
}
