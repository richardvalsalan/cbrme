<?php
class Adodis_Slideshow_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/slideshow?id=15 
    	 *  or
    	 * http://site.com/slideshow/id/15 	
    	 */
    	/* 
		$slideshow_id = $this->getRequest()->getParam('id');

  		if($slideshow_id != null && $slideshow_id != '')	{
			$slideshow = Mage::getModel('slideshow/slideshow')->load($slideshow_id)->getData();
		} else {
			$slideshow = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($slideshow == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$slideshowTable = $resource->getTableName('slideshow');
			
			$select = $read->select()
			   ->from($slideshowTable,array('slideshow_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$slideshow = $read->fetchRow($select);
		}
		Mage::register('slideshow', $slideshow);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}