<?php

class Adodis_Slideshow_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
	$model = Mage::registry('category_data');
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('slideshow_form', array('legend'=>Mage::helper('slideshow')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('slideshow')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('height', 'text', array(
          'label'     => Mage::helper('slideshow')->__('height'),
          'required'  => true,
          'name'      => 'height',
	  ));
	        $fieldset->addField('width', 'text', array(
          'label'     => Mage::helper('slideshow')->__('width'),
          'required'  => true,
          'name'      => 'width',
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
      $fieldset->addField('direct_nav', 'select', array(
          'label'     => Mage::helper('slideshow')->__('Directional Arrows'),
          'name'      => 'direct_nav',
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
      $fieldset->addField('control_nav', 'select', array(
          'label'     => Mage::helper('slideshow')->__('Control Navigation'),
          'name'      => 'control_nav',
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
      $fieldset->addField('duration', 'text', array(
          'label'     => Mage::helper('slideshow')->__('Duration(in microsec)'),
          'required'  => false,
          'name'      => 'duration',
	  ));	  
      $fieldset->addField('pausetime', 'text', array(
          'label'     => Mage::helper('slideshow')->__('Pause Time(in microsec)'),
          'required'  => false,
          'name'      => 'pausetime',
	  ));	  
      $fieldset->addField('effect', 'select', array(
          'label'     => Mage::helper('slideshow')->__('effect'),
          'name'      => 'effect',
          'values'    => array(
		  
		              array(
                  'value'     => Mage::helper('slideshow')->__('random'),
                  'label'     => Mage::helper('slideshow')->__('random'),
              ),
              array(
                  'value'     => Mage::helper('slideshow')->__('sliceUpDownLeft'),
                  'label'     => Mage::helper('slideshow')->__('sliceUpDownLeft'),
              ),

              array(
                  'value'     => Mage::helper('slideshow')->__('fade'),
                  'label'     => Mage::helper('slideshow')->__('Fade'),
              ),
			                array(
                  'value'     => Mage::helper('slideshow')->__('sliceDownRight'),
                  'label'     => Mage::helper('slideshow')->__('sliceDownRight'),
              ),
			                array(
                  'value'     => Mage::helper('slideshow')->__('sliceDownLeft'),
                  'label'     => Mage::helper('slideshow')->__('sliceDownLeft'),
              ),
			                array(
                  'value'     => Mage::helper('slideshow')->__('sliceUpRight'),
                  'label'     => Mage::helper('slideshow')->__('sliceUpRight'),
              ),
			  			                array(
                  'value'     => Mage::helper('slideshow')->__('sliceUpLeft'),
                  'label'     => Mage::helper('slideshow')->__('sliceUpLeft'),
              ),
			  			  			                array(
                  'value'     => Mage::helper('slideshow')->__('sliceUpDown'),
                  'label'     => Mage::helper('slideshow')->__('sliceUpDown'),
              ),
			  			  			  			                array(
                  'value'     => Mage::helper('slideshow')->__('fold'),
                  'label'     => Mage::helper('slideshow')->__('fold'),
              ),
			  			  			  			                array(
                  'value'     => Mage::helper('slideshow')->__('slideInRight'),
                  'label'     => Mage::helper('slideshow')->__('slideInRight'),
              ),			 
			  			  			  			                array(
                  'value'     => Mage::helper('slideshow')->__('slideInLeft'),
                  'label'     => Mage::helper('slideshow')->__('slideInLeft'),
              ),				  
          ),
      )); 	
	if (!Mage::app()->isSingleStoreMode()) {
		$fieldset->addField('store_id', 'multiselect', 
				array (
						'name' => 'stores[]', 
						'label' => Mage::helper('slideshow')->__('Store view'), 
						'title' => Mage::helper('slideshow')->__('Store view'), 
						'required' => true, 
						'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true) ));
	}
	else {
		$fieldset->addField('store_id', 'hidden', array (
				'name' => 'stores[]', 
				'value' => Mage::app()->getStore(true)->getId() ));
		$model->setStoreId(Mage::app()->getStore(true)->getId());
	} 
      
     
      if ( Mage::getSingleton('adminhtml/session')->getCategoryData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCategoryData());
          Mage::getSingleton('adminhtml/session')->getCategoryData(null);
      } elseif ( Mage::registry('category_data') ) {
          $form->setValues(Mage::registry('category_data')->getData());
      }
      return parent::_prepareForm();
  }
}