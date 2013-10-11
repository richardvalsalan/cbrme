<?php
class Adodis_Slideshow_Block_Slideshow extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSlideshow()     
     { 
				
        if (!$this->hasData('slideshow')) {
            $this->setData('slideshow', Mage::registry('slideshow'));
        }
        return $this->getData('slideshow');
        
    }
	
	public function getcategory()
	{
	        if (!$this->hasData('category')) {
            $this->setData('category', Mage::registry('category'));
        }
        return $this->getData('category');
	}
	
	public function slideCollection()
	{
	$categoryID = $this->getCategoryId();  
	$collection = Mage::getModel('slideshow/slideshow')->getCollection();
				$collection->getSelect()							
						   ->where("category_id = $categoryID")
						   ->where("status = 1");
					   
	return $collection;
	}
	
	public function categoryCollection()
	{
	$categoryID = $this->getCategoryId(); 
	$collection = Mage::getModel('slideshow/category')->getCollection();
	$collection->getSelect()
				->where("category_id = $categoryID")
				->where("status = 1");
				
	return $collection;
	}
}