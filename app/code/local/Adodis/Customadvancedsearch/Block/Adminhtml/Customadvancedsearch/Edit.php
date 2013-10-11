<?php

class Adodis_Customadvancedsearch_Block_Adminhtml_Customadvancedsearch_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'customadvancedsearch';
        $this->_controller = 'adminhtml_customadvancedsearch';

        $this->_updateButton(
            'save',
            'label',
            Mage::helper('customadvancedsearch')->__('Save Item')
        );

        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('customadvancedsearch')->__('Delete Item')
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
                if (tinyMCE.getInstanceById('customadvancedsearch_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'customadvancedsearch_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'customadvancedsearch_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('customadvancedsearch_data') && Mage::registry('customadvancedsearch_data')->getId()) {
            return Mage::helper('customadvancedsearch')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('customadvancedsearch_data')->getTitle()));
        }
        else {
            return Mage::helper('customadvancedsearch')->__('Add Item');
        }
    }
}
