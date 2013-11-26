<?php

class Adodis_Customadvancedsearch_Block_Catalogsearch_Advanced_Form extends Mage_CatalogSearch_Block_Advanced_Form
{
	public function getStoreCategories()
	{
		return Mage::helper('catalog/category')->getStoreCategories();
	}

	public function getAdvancedSearchPostUrl()
	{
		return $this->getUrl('catalogsearch/advanced/result');
	}

	public function getAttributeSelectElement($attribute)
    {
       $extra = '';
        $options = $attribute->getSource()->getAllOptions(false);

        $name = $attribute->getAttributeCode();

        array_unshift($options, array('value'=>'', 'label'=>Mage::helper('catalogsearch')->__('All')));

        return $this->_getSelectBlock()
            ->setName($name)
            ->setId($attribute->getAttributeCode())
            ->setTitle($this->getAttributeLabel($attribute))
            //->setExtraParams($extra)
            ->setValue($this->getAttributeValue($attribute))
            ->setOptions($options)
           // ->setClass('multiselect')
            ->getHtml();
    }
}