<?php

require_once ("app\Mage.php");
Mage::app('default');
	
set_time_limit(0);
ini_set('memory_limit', '1024M');

// enable error output
ini_set('display_errors', '1');
error_reporting(E_ALL);


$productCollection =  Mage::getResourceModel('catalog/product_collection')
	->addFieldToFilter('status', array(
		'eq' => '1'
	)	
	);
foreach ($productCollection as $product)
{
	$dateAndTime = $product->getCreatedAt();
	$date = explode(' ', $dateAndTime);
	$_date = $date['0'];

	$_product = Mage::getModel('catalog/product')->load($product->getId());

	$productName = $_product->getName();
	$email = $_product->getEmail();

	$expiryMonth = $_product->getExpiryMonth();

	switch ($expiryMonth) {
		case 3 :
			if (date('Y-m-d', strtotime($_date .' +83 day')) == date('Y-m-d')) {

				$message = getAlertMessage($productName, 7);
				sendemail($message, $email);
			// } else if (date('Y-m-d', strtotime($_date .' +90 day')) == date('Y-m-d')) {

			 } else {

				$message = getExpiredMessage($productName);

				//send mail
				sendemail($message, $email);

				//Disable the Product/ad
				disableProduct($_product);
				
			}
			break;

		case 6 :
			if (date('Y-m-d', strtotime($_date .' +173 day')) == date('Y-m-d')) {
				$message = getAlertMessage($productName, 7);

				sendemail($message, $email);

				disableProduct($_product);
			} else if (date('Y-m-d', strtotime($_date .' +180 day')) == date('Y-m-d')) {
				$message = getExpiredMessage($productName);

				sendemail($message, $email);
				
				//Disable the Product/ad
				disableProduct($_product);
			}
			break;

		case 12 :
			if (date('Y-m-d', strtotime($_date .' +358 day')) == date('Y-m-d')) {
				$message = getAlertMessage($productName, 7);

				sendemail($message, $email);
			} else if (date('Y-m-d', strtotime($_date .' +365 day')) == date('Y-m-d')) {
				$message = getExpiredMessage($productName);

				sendemail($message, $email);

				//Disable the Product/ad
				disableProduct($_product);
			}

	}

	echo "done";
}

function sendemail($message, $email) 
{
	$to = $email;
	$dt = date('d-m-Y');

	$subject = "CBRME";

	$mail = new Zend_Mail();
    $mail->setBodyHtml($message);
    $mail->setFrom('info@cbrme.com', 'Customer');
    $mail->addTo($to, $to);
    $mail->setSubject($subject);

    $mail->send();
}

function getAlertMessage($adname, $days)
{
	$html = "<html>
		<head>
			<title></title.
		</head>
		<body>
			<p>Dear Customer, </p>

			<br />

			Your " . $adname . " Ad with the CBRME Site is due to expiration in " . $days . " days.Contact us for further details.
		</body>

	</html>";

	return $html;
}

function getExpiredMessage($adname)
{
	$html = "<html>
		<head>
			<title></title.
		</head>
		<body>
			<p>Dear Customer, </p>

			<br />

			Your " . $adname . " Ad with the CBRME Site has been expired.Kindly contact us for further details.
		</body>

	</html>";

	return $html; 
}

function disableProduct($_product)
{
	if ($_product->getAttributeText('banner_ad') == 'No') {
		$_product->setStatus(2)->save();
	} else {
		$_product->setStatus(2)->save();

		$slideShowmodel = Mage::getModel('slideshow/slideshow')
			->getCollection()
			->addFieldToFilter('product_sku', array(
				'eq' => $_product->getSku()
			)
			)
			->getFirstItem();

		$_model = Mage::getModel('slideshow/slideshow')->load($slideShowmodel->getId());

		$_model->setStatus(2)->save();
	}
}
