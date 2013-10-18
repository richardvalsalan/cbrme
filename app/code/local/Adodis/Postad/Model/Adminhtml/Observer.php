<?php

class Adodis_Postad_Model_Adminhtml_Observer
{
	public function adminhtml_sales_order_create_process_data(Varien_Event_Observer $observer)
	{
		try {
			$requestData = $observer->getEvent()->getRequest();

			if (isset($requestData['order']['enable_ad'])) {
				$observer->getEvent()->getOrderCreateModel()->getQuote()
					->addData($requestData['order'])
					->save();
			}
		} catch (Exception $e) {
			Mage::logException($e);
		}

		return $this;
	}
}