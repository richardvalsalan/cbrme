<?php

class Adodis_Customadvancedsearch_Block_Adminhtml_Customadvancedsearch_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'customadvancedsearch_form',
            array(
                'legend'=>Mage::helper('customadvancedsearch')->__('Item information')
            )
        );

        $fieldset->addField(
            'title',
            'text',
            array(
                'label' => Mage::helper('customadvancedsearch')->__('Title'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'title',
            )
        );

        $fieldset->addField(
            'filename',
            'file',
            array(
                'label' => Mage::helper('customadvancedsearch')->__('File'),
                'required' => false,
                'name' => 'filename',
            )
        );

        $fieldset->addField(
            'status',
            'select',
            array(
                'label' => Mage::helper('customadvancedsearch')->__('Status'),
                'name' => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('customadvancedsearch')->__('Enabled'),
                    ),

                    array(
                        'value' => 2,
                        'label' => Mage::helper('customadvancedsearch')->__('Disabled'),
                    ),
                ),
            )
        );

        $fieldset->addField(
            'content',
            'editor',
            array(
                'name' => 'content',
                'label' => Mage::helper('customadvancedsearch')->__('Content'),
                'title' => Mage::helper('customadvancedsearch')->__('Content'),
                'style' => 'width:700px; height:500px;',
                'wysiwyg' => false,
                'required' => true,
            )
        );

        if (Mage::getSingleton('adminhtml/session')->getCustomadvancedsearchData()) {
            $form->setValues(
                Mage::getSingleton('adminhtml/session')->getCustomadvancedsearchData()
            );
            Mage::getSingleton('adminhtml/session')->setCustomadvancedsearchData(null);
        }
        elseif (Mage::registry('customadvancedsearch_data')) {
            $form->setValues(
                Mage::registry('customadvancedsearch_data')->getData()
            );
        }

        return parent::_prepareForm();
    }
}
