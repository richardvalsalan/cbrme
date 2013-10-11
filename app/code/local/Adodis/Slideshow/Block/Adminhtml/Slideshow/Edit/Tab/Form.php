<?php

class Adodis_Slideshow_Block_Adminhtml_Slideshow_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{ 
 protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('slideshow_form', array('legend'=>Mage::helper('slideshow')->__('Slide information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('slideshow')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('slideshow')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('slideshow')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('slideshow')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('slideshow')->__('Disabled'),
              ),
          ),
      )); 
      $fieldset->addField('url', 'text', array(
          'label'     => Mage::helper('slideshow')->__('Url'),
          'name'      => 'url',
      ));
      $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('slideshow')->__('category'),
          'name'      => 'category_id',
		  'class'     => 'required-entry',
          'required'  => true,
          'values'    => Mage::getSingleton('slideshow/category')->getcat(),
      )); 	  
      
     
      if ( Mage::getSingleton('adminhtml/session')->getSlideshowData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSlideshowData());
          Mage::getSingleton('adminhtml/session')->setSlideshowData(null);
      } elseif ( Mage::registry('slideshow_data') ) {
          $form->setValues(Mage::registry('slideshow_data')->getData());
      }
      return parent::_prepareForm();
  }
}