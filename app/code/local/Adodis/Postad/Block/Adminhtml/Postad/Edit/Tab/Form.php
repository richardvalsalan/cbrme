<?php

class Adodis_Postad_Block_Adminhtml_Postad_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'postad_form',
            array(
                'legend'=>Mage::helper('postad')->__('Item information')
            )
        );

        $fieldset->addField(
            'title',
            'text',
            array(
                'label' => Mage::helper('postad')->__('Title'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'title',
            )
        );

        $fieldset->addField(
            'filename',
            'file',
            array(
                'label' => Mage::helper('postad')->__('File'),
                'required' => false,
                'name' => 'filename',
            )
        );

        $fieldset->addField(
            'status',
            'select',
            array(
                'label' => Mage::helper('postad')->__('Status'),
                'name' => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('postad')->__('Enabled'),
                    ),

                    array(
                        'value' => 2,
                        'label' => Mage::helper('postad')->__('Disabled'),
                    ),
                ),
            )
        );

        $fieldset->addField(
            'content',
            'editor',
            array(
                'name' => 'content',
                'label' => Mage::helper('postad')->__('Content'),
                'title' => Mage::helper('postad')->__('Content'),
                'style' => 'width:700px; height:500px;',
                'wysiwyg' => false,
                'required' => true,
            )
        );

        if (Mage::getSingleton('adminhtml/session')->getPostadData()) {
            $form->setValues(
                Mage::getSingleton('adminhtml/session')->getPostadData()
            );
            Mage::getSingleton('adminhtml/session')->setPostadData(null);
        }
        elseif (Mage::registry('postad_data')) {
            $form->setValues(
                Mage::registry('postad_data')->getData()
            );
        }

        return parent::_prepareForm();
    }
}
